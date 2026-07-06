@extends('pesanan.base')

@section('title', 'Konfirmasi Pesanan - SALZA')
@section('page-title', 'Konfirmasi Pesanan')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Pesanan info -->
    <div class="bg-dashboard-card rounded-2xl border border-slate-700/30 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-700/50 flex items-center gap-4">
            <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                <i class="fa-solid fa-clipboard-check text-blue-400 text-xs"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-white">Konfirmasi Pesanan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pastikan data pesanan sudah benar sebelum mengkonfirmasi.</p>
            </div>
        </div>

        <!-- Detail pesanan -->
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 p-6">
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-slate-700/50 rounded-xl border border-slate-700/50 p-4">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Kode Pesanan</p>
                    <p class="text-lg font-bold text-white coupon-code" id="detailCode">-</p>
                </div>
                <div class="bg-slate-700/50 rounded-xl border border-slate-700/50 p-4">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Pelanggan</p>
                    <p class="text-sm text-white font-medium" id="detailCustomer">-</p>
                </div>
                <div class="bg-slate-700/50 rounded-xl border border-slate-700/50 p-4">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Pesanan</p>
                    <p class="text-lg font-bold text-white" id="detailTotal">Rp0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel items -->
    <div class="bg-dashboard-card rounded-2xl border border-slate-700/30 overflow-hidden mb-6">
        <div class="px-6 border-b border-slate-700/50 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-white">Daftar Pesanan Item</h3>
            <span class="text-xs text-slate-500">Pesanan #<span class="text-white font-semibold" id="detailId">-</span></span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                        <th class="px-6 py-3 w-14">No.</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3 text-right">Harga</th>
                        <th class="px-6 py-3 text-center w-20">Qty</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="pesananItems" class="divide-y divide-slate-700/50">
                    <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500 italic">Belum ada item.</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol konfirmasi -->
    <div class="bg-dashboard-card rounded-2xl border border-blue-500/30 overflow-hidden">
        <div class="p-6 border-b border-slate-700/50 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                <i class="fa-solid fa-check text-blue-400 text-xs"></i>
            </div>
            <h3 class="text-sm font-semibold text-white">Konfirmasi Pesanan</h3>
        </div>
        <div class="p-6">
            <div class="bg-slate-800 rounded-xl border border-slate-700/50 p-5 mb-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-slate-700 flex items-center justify-center">
                        <i class="fa-solid fa-receipt text-slate-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white" id="confirmCode">-</p>
                    </div>
                </div>
            </div>
            <div class="border border-amber-500/20 bg-amber-500/5 rounded-xl border-dashed border-l-4 pl-5 py-3 mb-5">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-circle-exclamation text-amber-500 text-sm"></i>
                    <p class="p-0 text-sm font-semibold text-amber-200">Pastikan data pesanan sudah benar sebelum mengkonfirmasi.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.pesanan.masuk') }}" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors text-center">
                    <i class="fa-solid fa-arrow-left mr-1.5 text-xs"></i>Kembali
                </a>
                <button type="button" id="confirmBtn" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>Konfirmasi
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
