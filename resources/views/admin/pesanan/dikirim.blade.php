@extends('pesanan.base')

@section('title', 'Dikirim - SALZA')
@section('page-title', 'Dikirim')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.row-hover{transition:background .15s,box-shadow .15s}
.row-hover:hover{background:rgba(139,92,246,.08);box-shadow:inset 3px 0 0 #a855f7}
@keyframes toastIn{from{opacity:0;transform:translateX(100%)}to{opacity:1;transform:translateX(0)}}
@keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(100%)}}
.toast-in{animation:toastIn .3s ease forwards}
.toast-out{animation:toastOut .25s ease forwards}
.status-badge{display:inline-flex;align-items:center;gap:3px;padding:4px 10px;border-radius:8px;font-size:12px;font-weight:600}
</style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Status badge -->
    <div class="bg-dashboard-card rounded-2xl border border-cyan-500/30 overflow-hidden mb-6">
        <div class="border-b border-slate-700/50 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-cyan-500/20 flex items-center justify-center">
                <i class="fa-solid fa-truck text-cyan-400 text-xs"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-white">Dikirim</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pesanan sedang dalam pengiriman</p>
            </div>
        </div>
    </div>

    <!-- Detail pesanan -->
    <div class="bg-dashboard-card rounded-2xl border border-slate-700/30 overflow-hidden mb-6">
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
                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">Belum ada item.</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol -->
    <div class="bg-dashboard-card rounded-2xl border border-cyan-500/30 overflow-hidden">
        <div class="p-6">
            <div class="border border-cyan-500/20 bg-cyan-500/5 rounded-xl border-dashed border-l-4 pl-5 py-3 mb-5">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-truck text-cyan-500 text-sm"></i>
                    <p class="p-0 text-sm font-semibold text-cyan-200">Pastikan pesanan sudah benar sebelum dikirim.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.pesanan.masuk') }}" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors text-center">
                    <i class="fa-solid fa-arrow-left mr-1.5 text-xs"></i>Kembali
                </a>
                <button type="button" id="statusBtn" class="flex-1 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-bold rounded-lg shadow-md shadow-cyan-500/20 hover:shadow-lg hover:shadow-cyan-500/30 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-truck text-xs"></i>Status Dikirim
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
