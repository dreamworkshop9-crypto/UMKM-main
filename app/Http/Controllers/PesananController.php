<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    private const FLOW = [
        'menunggu'      => ['dikonfirmasi', 'dibatalkan'],
        'dikonfirmasi'  => ['dikemas'],
        'dikemas'       => ['dikirim'],
        'dikirim'       => ['diperjalanan'],
        'diperjalanan'  => ['selesai'],
    ];

    private function getByStatus(string $status, Request $request)
    {
        $query = Pesanan::where('status', $status);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('invoice', 'LIKE', "%{$s}%")
                  ->orWhere('shipping_name', 'LIKE', "%{$s}%")
                  ->orWhere('shipping_phone', 'LIKE', "%{$s}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($request->per_page ?? 10);
    }

    public function masuk(Request $request)
    {
        $pesanan = $this->getByStatus('menunggu', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))->with('pageTitle', 'Pesanan Masuk')->with('statusKey', 'menunggu');
    }

    public function dikonfirmasi(Request $request)
    {
        $pesanan = $this->getByStatus('dikonfirmasi', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))->with('pageTitle', 'Pesanan Dikonfirmasi')->with('statusKey', 'dikonfirmasi');
    }

    public function dikemas(Request $request)
    {
        $pesanan = $this->getByStatus('dikemas', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))->with('pageTitle', 'Pesanan Dikemas')->with('statusKey', 'dikemas');
    }

    public function dikirim(Request $request)
    {
        $pesanan = $this->getByStatus('dikirim', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))->with('pageTitle', 'Pesanan Dikirim')->with('statusKey', 'dikirim');
    }

    public function diperjalanan(Request $request)
    {
        $pesanan = $this->getByStatus('diperjalanan', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))->with('pageTitle', 'Pesanan Dalam Perjalanan')->with('statusKey', 'diperjalanan');
    }

    public function selesai(Request $request)
    {
        $pesanan = $this->getByStatus('selesai', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))->with('pageTitle', 'Pesanan Selesai')->with('statusKey', 'selesai');
    }

    public function dibatalkan(Request $request)
    {
        $pesanan = $this->getByStatus('dibatalkan', $request);
        return view('admin.pesanan.dibatalkan', compact('pesanan'))->with('pageTitle', 'Pembatalan')->with('statusKey', 'dibatalkan');
    }

    public function pengembalian(Request $request)
    {
        $pesanan = Pesanan::where('status', 'selesai')
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                $q->where('invoice', 'LIKE', "%{$s}%")
                  ->orWhere('shipping_name', 'LIKE', "%{$s}%")
                  ->orWhere('shipping_phone', 'LIKE', "%{$s}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return view('admin.pengembalian', compact('pesanan'))
            ->with('pageTitle', 'Pengembalian')
            ->with('statusKey', 'pengembalian');
    }

    public function show($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    private function kurangiStok(Pesanan $pesanan)
    {
        foreach ($pesanan->items as $item) {
            if ($item->produk) {
                if ($item->produk->stock < $item->quantity) {
                    throw new \Exception("Stok produk '{$item->produk->name}' tidak mencukupi (Sisa: {$item->produk->stock}, Kebutuhan: {$item->quantity}).");
                }
                $item->produk->decrement('stock', $item->quantity);
            }
        }
    }

    private function ubahStatus(Request $request, $id, string $nextStatus)
    {
        $pesanan = Pesanan::findOrFail($id);
        $current = $pesanan->status;

        $allowed = self::FLOW[$current] ?? [];
        if (!in_array($nextStatus, $allowed)) {
            return back()->with('error', "Gagal: status tidak valid.");
        }

        DB::beginTransaction();
        try {
            if ($nextStatus === 'dikonfirmasi') {
                $this->kurangiStok($pesanan);
            }
            
            $pesanan->update(['status' => $nextStatus]);
            DB::commit();

            $routeName = 'admin.pesanan.' . $nextStatus;
            return redirect()->route($routeName)
                ->with('success', "Pesanan {$pesanan->invoice} berhasil diubah ke '" . str_replace('_', ' ', ucfirst($nextStatus)) . "'");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function aksiKonfirmasi(Request $request, $id) { return $this->ubahStatus($request, $id, 'dikonfirmasi'); }
    public function aksiDikemas(Request $request, $id) { return $this->ubahStatus($request, $id, 'dikemas'); }
    public function aksiDikirim(Request $request, $id) { return $this->ubahStatus($request, $id, 'dikirim'); }
    public function aksiDiperjalanan(Request $request, $id) { return $this->ubahStatus($request, $id, 'diperjalanan'); }
    public function aksiSelesai(Request $request, $id) { return $this->ubahStatus($request, $id, 'selesai'); }

    public function aksiDibatalkan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        if ($pesanan->status !== 'menunggu') {
            return back()->with('error', "Hanya pesanan 'menunggu' yang bisa dibatalkan");
        }
        $pesanan->update(['status' => 'dibatalkan']);
        return redirect()->route('admin.pesanan.dibatalkan')->with('success', "Pesanan {$pesanan->invoice} berhasil dibatalkan");
    }

    public function aksiVerifikasiPembayaran(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $this->kurangiStok($pesanan);

            $pesanan->update([
                'payment_status' => 'paid',
                'status'         => 'dikonfirmasi'
            ]);
            DB::commit();

            return redirect()->route('admin.pesanan.dikonfirmasi')
                ->with('success', "Pembayaran untuk pesanan {$pesanan->invoice} berhasil diverifikasi!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}