<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index(Request $request)
    {
        $query = Ulasan::with(['user', 'pesanan']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('review', 'LIKE', "%{$s}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'LIKE', "%{$s}%"))
                  ->orWhereHas('pesanan', fn($p) => $p->where('code', 'LIKE', "%{$s}%"));
            });
        }

        $ulasan = $query->orderBy('created_at', 'desc')->paginate($request->per_page ?? 10);

        return view('admin.ulasan', compact('ulasan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $ulasan = Ulasan::findOrFail($id);
        $ulasan->update(['status' => $request->status]);

        return response()->json([
            'message' => "Ulasan berhasil diperbarui",
        ]);
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();

        return response()->json([
            'message' => "Ulasan berhasil dihapus",
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|integer|exists:pesanans,id',
            'rating'     => 'required|integer|min:1|max:5',
            'review'     => 'required|string|min:5|max:1000',
        ]);

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi habis, silakan login ulang.'
            ], 401);
        }

        $order = \App\Models\Order::where('id', $request->pesanan_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan atau bukan milik Anda.'
            ], 404);
        }

        if ($order->status !== 'selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Anda hanya bisa memberikan ulasan jika pesanan sudah selesai (diterima).'
            ], 422);
        }

        $existing = Ulasan::where('pesanan_id', $order->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan ulasan untuk pesanan ini.'
            ], 422);
        }

        $ulasan = Ulasan::create([
            'pesanan_id' => $order->id,
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'review'     => $request->review,
            'status'     => 'aktif',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Ulasan Anda berhasil dikirim.',
            'data' => $ulasan
        ]);
    }
}