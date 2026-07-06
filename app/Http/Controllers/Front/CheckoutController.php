<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah'    => 'required|integer|min:1',
            'alamat'    => 'nullable|string|min:10',
        ]);

        $produk = Product::findOrFail($request->produk_id);

        if ($produk->stock < $request->jumlah) {
            return back()->withErrors(['stok' => 'Stok produk tidak mencukupi.'])->withInput();
        }

        $order = Order::create([
            'user_id'          => Auth::id(),
            'invoice'          => 'INV-' . strtoupper(Str::random(10)),
            'total'            => $produk->price * $request->jumlah,
            'payment_method'   => 'cod',
            'payment_status'   => 'pending',
            'status'           => 'menunggu',
            'shipping_name'    => Auth::user()->name,
            'shipping_phone'   => Auth::user()->phone ?? '-',
            'shipping_address' => $request->alamat ?? '-',
        ]);

        DB::table('order_items')->insert([
            'order_id'   => $order->id,
            'product_id' => $produk->id,
            'quantity'   => $request->jumlah,
            'price'      => $produk->price,
            'size'       => null,
            'color'      => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pesanan.sukses');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat'     => 'required|string|min:10',
            'provinsi'   => 'required|string',
            'kota'       => 'required|string',
            'kurir'      => 'required|string',
            'ongkir'     => 'required|integer|min:0',
            'pembayaran' => 'required|string',
            'catatan'    => 'nullable|string',
            'coupon'     => 'nullable|string',
            'total'      => 'required|integer|min:1',
            'cart_item_ids' => 'nullable|array',
            'cart_item_ids.*' => 'integer|exists:carts,id',
        ]);

        $query = Keranjang::with('produk')->where('user_id', Auth::id());
        if ($request->has('cart_item_ids') && is_array($request->cart_item_ids)) {
            $query->whereIn('id', $request->cart_item_ids);
        }
        $items = $query->get();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'Pilih produk yang ingin dibeli'], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Sesi habis, silakan login ulang.'], 401);
        }

        // 1. Validasi produk di luar transaction (jangan ada return response di dalam transaction)
        foreach ($items as $item) {
            if (!$item->produk) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan atau sudah dihapus. Silakan hapus dari keranjang.'
                ], 422);
            }
            if ($item->produk->stock < ($item->qty ?? $item->quantity)) {
                return response()->json([
                    'message' => 'Stok produk "' . $item->produk->name . '" tidak mencukupi (Tersedia: ' . $item->produk->stock . ').'
                ], 422);
            }
        }

        // 2. Jalankan transaction
        return DB::transaction(function () use ($request, $items, $user) {
            $uniqueCode = 0;
            $total = (int) $request->total;
            if ($request->pembayaran === 'transfer') {
                $uniqueCode = rand(100, 999);
                $total += $uniqueCode;
            }
            
            $order = Order::create([
                'user_id'          => $user->id,
                'invoice'          => 'INV-' . strtoupper(Str::random(10)),
                'total'            => $total,
                'unique_code'      => $uniqueCode,
                'payment_method'   => $request->pembayaran ?? 'cod',
                'payment_status'   => $request->pembayaran === 'cod' ? 'pending' : 'unpaid',
                'status'           => 'menunggu',
                'shipping_name'    => $user->name,
                'shipping_phone'   => $user->phone ?? '-',
                'shipping_address' => $request->alamat . ', ' . ucwords(str_replace('-', ' ', $request->kota)) . ', ' . ucwords(str_replace('-', ' ', $request->provinsi)),
                'notes'            => $request->catatan ?? null,
            ]);

            // Pengaman: pastikan order benar-benar terbuat
            if (!$order || !$order->id) {
                throw new \Exception('Gagal membuat pesanan utama.');
            }

            foreach ($items as $item) {
                DB::table('order_items')->insert([
                    'order_id'   => $order->id,
                    'product_id' => $item->produk_id ?? $item->product_id,
                    'quantity'   => $item->qty ?? $item->quantity,
                    'price'      => $item->produk->price, 
                    'size'       => $item->size ?? null,
                    'color'      => $item->color ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($request->has('cart_item_ids') && is_array($request->cart_item_ids)) {
                Keranjang::whereIn('id', $request->cart_item_ids)->delete();
            } else {
                Keranjang::where('user_id', $user->id)->delete();
            }

            if ($request->pembayaran !== 'cod') {
                $simulatedVa = null;
                if (strpos($request->pembayaran, 'va_') === 0) {
                    $simulatedVa = '8' . implode('', array_map(function() { return rand(0, 9); }, range(1, 15)));
                }

                return response()->json([
                    'success' => true,
                    'data'    => [
                        'code'         => $order->invoice,
                        'redirect_url' => null,
                        'va_number'    => $simulatedVa,
                        'qr_url'       => null,
                        'total'        => $order->total,
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'data'    => ['code' => $order->invoice],
            ]);
        });
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->hasFile('bukti')) {
            // Hapus file lama jika ada
            if ($order->payment_proof) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('bukti')->store('bukti_pembayaran', 'public');
            $order->update([
                'payment_proof' => $path,
                'payment_status' => 'menunggu_verifikasi',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diunggah. Silakan tunggu konfirmasi dari kami.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File bukti pembayaran tidak ditemukan.',
        ], 400);
    }
}