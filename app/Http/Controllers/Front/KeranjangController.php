<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Tampilkan semua isi keranjang belanja.
     */
    public function index()
    {
        $items = $this->getCartItems();
        return response()->json([
            'success' => true,
            'data'    => $items
        ]);
    }

    /**
     * Tambahkan produk ke keranjang belanja.
     */
    public function tambah(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.'
            ], 401);
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'ukuran'    => 'nullable|string',
            'warna'     => 'nullable|string',
            'qty'       => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->produk_id);
        $qty = (int) ($request->qty ?? 1);

        // Cek jika produk yang diminta melebihi stok yang ada
        if ($qty > $product->stock) {
            return response()->json([
                'message' => 'Stok produk tidak mencukupi.'
            ], 422);
        }

        // Cari apakah produk dengan ukuran dan warna yang sama sudah ada di keranjang user
        $existing = Keranjang::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('size', $request->ukuran)
            ->where('color', $request->warna)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $qty;
            if ($newQty > $product->stock) {
                return response()->json([
                    'message' => 'Stok maksimal ' . $product->stock
                ], 422);
            }
            $existing->update(['quantity' => $newQty]);
        } else {
            Keranjang::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => $qty,
                'size'       => $request->ukuran,
                'color'      => $request->warna,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'data'    => $this->getCartItems()
        ], 201);
    }

    /**
     * Perbarui jumlah (qty) produk di keranjang.
     */
    public function updateQty(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        $request->validate([
            'qty' => 'required|integer'
        ]);

        $item = Keranjang::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $qty = (int) $request->qty;

        if ($qty <= 0) {
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari keranjang.',
                'data'    => $this->getCartItems()
            ]);
        }

        if ($qty > ($item->produk->stock ?? 0)) {
            return response()->json([
                'message' => 'Stok maksimal ' . ($item->produk->stock ?? 0)
            ], 422);
        }

        $item->update(['quantity' => $qty]);

        return response()->json([
            'success' => true,
            'message' => 'Kuantitas diperbarui.',
            'data'    => $this->getCartItems()
        ]);
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function hapus($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        Keranjang::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang.',
            'data'    => $this->getCartItems()
        ]);
    }

    /**
     * Helper untuk mengambil data keranjang belanja yang sudah diformat sesuai kebutuhan view frontend.
     */
    private function getCartItems()
    {
        if (!Auth::check()) {
            return [];
        }

        return Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(fn ($item) => [
                'id'        => $item->id,
                'produk_id' => $item->product_id,
                'nama'      => $item->produk->name ?? '',
                'foto'      => $item->produk->thumbnail_url ?? '',
                'harga'     => (int) ($item->produk->price ?? 0),
                'ukuran'    => $item->size,
                'warna'     => $item->color,
                'qty'       => (int) $item->quantity,
            ])
            ->toArray();
    }
}
