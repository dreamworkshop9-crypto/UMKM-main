@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1200px] mx-auto space-y-6">
    
    <!-- Header Banner -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-xl">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400">
                <span class="material-symbols-outlined text-[24px]">dashboard</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">Selamat Datang, Administrator!</h1>
                <p class="text-xs text-slate-500 mt-1">Berikut adalah ringkasan performa penjualan dan statistik toko Anda hari ini.</p>
            </div>
        </div>
        <div class="bg-slate-900/60 border border-outline-variant/20 px-4 py-2 rounded-xl flex items-center gap-2 text-xs text-slate-400">
            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
            <span class="font-semibold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    <!-- Core Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Total Pendapatan -->
        <div class="bg-[#1c1c2d] rounded-2xl p-5 border border-outline-variant/20 shadow-xl flex items-center gap-4 hover:border-emerald-500/30 transition-all group">
            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 group-hover:scale-105 transition-transform duration-300">
                <span class="material-symbols-outlined text-[24px]">payments</span>
            </div>
            <div class="space-y-1">
                <p class="text-slate-500 text-[11px] font-bold uppercase tracking-wider">Pendapatan</p>
                <h3 class="text-white text-lg font-extrabold font-mono">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-400 flex items-center gap-0.5">
                    <span class="material-symbols-outlined text-[12px]">check_circle</span> Transaksi Sukses
                </p>
            </div>
        </div>

        <!-- Card 2: Total Pesanan -->
        <div class="bg-[#1c1c2d] rounded-2xl p-5 border border-outline-variant/20 shadow-xl flex items-center gap-4 hover:border-indigo-500/30 transition-all group">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 group-hover:scale-105 transition-transform duration-300">
                <span class="material-symbols-outlined text-[24px]">shopping_bag</span>
            </div>
            <div class="space-y-1">
                <p class="text-slate-500 text-[11px] font-bold uppercase tracking-wider">Total Pesanan</p>
                <h3 class="text-white text-lg font-extrabold font-mono">{{ number_format($totalOrders, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-slate-400">Seluruh transaksi masuk</p>
            </div>
        </div>

        <!-- Card 3: Pesanan Menunggu -->
        <div class="bg-[#1c1c2d] rounded-2xl p-5 border border-outline-variant/20 shadow-xl flex items-center gap-4 hover:border-amber-500/30 transition-all group">
            <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-400 group-hover:scale-105 transition-transform duration-300">
                <span class="material-symbols-outlined text-[24px]">pending_actions</span>
            </div>
            <div class="space-y-1">
                <p class="text-slate-500 text-[11px] font-bold uppercase tracking-wider">Pesanan Pending</p>
                <h3 class="text-white text-lg font-extrabold font-mono">{{ number_format($pendingOrders, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-amber-400 flex items-center gap-0.5">
                    <span class="material-symbols-outlined text-[12px]">schedule</span> Menunggu konfirmasi
                </p>
            </div>
        </div>

        <!-- Card 4: Total Produk -->
        <div class="bg-[#1c1c2d] rounded-2xl p-5 border border-outline-variant/20 shadow-xl flex items-center gap-4 hover:border-cyan-500/30 transition-all group">
            <div class="w-12 h-12 bg-cyan-500/10 rounded-xl flex items-center justify-center text-cyan-400 group-hover:scale-105 transition-transform duration-300">
                <span class="material-symbols-outlined text-[24px]">inventory_2</span>
            </div>
            <div class="space-y-1">
                <p class="text-slate-500 text-[11px] font-bold uppercase tracking-wider">Total Produk</p>
                <h3 class="text-white text-lg font-extrabold font-mono">{{ number_format($totalProducts, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-slate-400">Item aktif di katalog</p>
            </div>
        </div>

    </div>

    <!-- Two-Column Analytics Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Recent Orders (Width: 2/3) -->
        <div class="lg:col-span-2 bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-400 text-[20px]">list_alt</span>
                        Daftar Pesanan Terbaru
                    </h3>
                    <a href="{{ route('admin.pesanan.masuk') }}" class="text-[11px] text-indigo-400 hover:text-indigo-300 font-bold flex items-center gap-1 transition-colors">
                        Lihat Semua <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#24243a] border-b border-outline-variant/10">
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Invoice</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Total</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Metode</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-[#1a1a2e] transition-colors">
                                <td class="px-6 py-3.5">
                                    <span class="font-mono text-xs font-semibold text-slate-300">{{ $order->invoice }}</span>
                                </td>
                                <td class="px-6 py-3.5 text-xs text-slate-200 font-medium">
                                    {{ $order->shipping_name }}
                                </td>
                                <td class="px-6 py-3.5 text-xs text-emerald-400 text-right font-bold font-mono">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-full border border-slate-700/50 bg-slate-800 text-slate-400 uppercase">
                                        {{ $order->payment_method }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    @php
                                        $bc = [
                                            'menunggu' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'dikonfirmasi' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'dikemas' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                            'dikirim' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
                                            'diperjalanan' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
                                            'selesai' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'dibatalkan' => 'bg-red-500/10 text-red-400 border-red-500/20'
                                        ];
                                    @endphp
                                    <span class="text-[9px] font-bold px-2.5 py-0.5 rounded-full border {{ $bc[$order->status] ?? 'bg-slate-500/10 text-slate-400' }} uppercase">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    <a href="{{ route('admin.pesanan.show', $order->id) }}" class="w-7 h-7 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 flex items-center justify-center text-indigo-400 hover:text-indigo-300 transition-colors mx-auto" title="Detail Pesanan">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500 text-xs">
                                    <div class="flex flex-col items-center gap-2 py-4">
                                        <span class="material-symbols-outlined text-[36px] opacity-10">inbox</span>
                                        <span>Tidak ada pesanan baru ditemukan</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Best Sellers (Width: 1/3) -->
        <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-400 text-[20px]">local_fire_department</span>
                    <h3 class="text-sm font-semibold text-white">Produk Terlaris (Top 5)</h3>
                </div>
                
                <div class="p-5 space-y-4">
                    @forelse($bestSellers as $item)
                        @if($item->product)
                        <div class="flex items-center gap-3.5 pb-3 border-b border-outline-variant/5 last:border-0 last:pb-0">
                            <div class="w-11 h-11 rounded-lg bg-[#121220] border border-outline-variant/20 flex items-center justify-center overflow-hidden flex-shrink-0">
                                <img src="{{ $item->product->thumbnail_url ?? asset('images/default-product.png') }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-xs font-bold text-white block truncate leading-tight hover:text-indigo-400 transition-colors">
                                    {{ $item->product->name }}
                                </span>
                                <span class="text-[10px] text-slate-500 font-medium block mt-0.5">
                                    Total Omset: <span class="text-emerald-400 font-bold font-mono">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                                </span>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full border border-purple-500/20 bg-purple-500/10 text-purple-400">
                                    {{ $item->total_sold }} Terjual
                                </span>
                            </div>
                        </div>
                        @endif
                    @empty
                    <div class="text-center py-10 text-slate-500 text-xs">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-[36px] opacity-10">monitoring</span>
                            <span>Belum ada data penjualan produk</span>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection