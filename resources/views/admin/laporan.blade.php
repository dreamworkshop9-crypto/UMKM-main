@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('additional-css')
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Laporan Penjualan</h1>
        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[14px]">calendar_today</span>
            {{ $labelPeriode }}
        </p>
    </div>
    
    <!-- Filter Toolbar -->
    <div class="flex flex-wrap items-center gap-3">
        <div class="flex flex-col">
            <label class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1.5">Periode</label>
            <select class="bg-[#1c1c2d] border border-outline-variant/30 rounded-xl px-4 py-2 text-slate-300 text-[13px] focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none cursor-pointer transition-colors" id="filterPeriode" onchange="toggleCustom()">
                <option value="hari_ini" {{ $periode === 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu_ini" {{ $periode === 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan_ini" {{ $periode === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="bulan_lalu" {{ $periode === 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                <option value="tahun_ini" {{ $periode === 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="custom" {{ $periode === 'custom' ? 'selected' : '' }}>Custom Range</option>
            </select>
        </div>
        <div id="customRange" class="{{ $periode === 'custom' ? 'flex' : 'hidden' }} items-center gap-3">
            <div class="flex flex-col">
                <label class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1.5">Dari</label>
                <input type="date" class="bg-[#1c1c2d] border border-outline-variant/30 rounded-xl px-4 py-2 text-white text-[13px] focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors" id="filterDari" value="{{ $dari ?? '' }}"/>
            </div>
            <div class="flex flex-col">
                <label class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1.5">Sampai</label>
                <input type="date" class="bg-[#1c1c2d] border border-outline-variant/30 rounded-xl px-4 py-2 text-white text-[13px] focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors" id="filterSampai" value="{{ $sampai ?? '' }}"/>
            </div>
        </div>
        <div class="flex flex-col justify-end pt-[22px]">
            <button class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 text-white font-semibold text-[13px] rounded-xl px-5 py-2 transition-all flex items-center gap-1.5 shadow-lg shadow-indigo-500/10" onclick="applyFilter()">
                <span class="material-symbols-outlined text-[16px]">filter_list</span>
                Terapkan
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat 1: Pendapatan -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 shadow-xl hover:border-emerald-500/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Total Pendapatan</span>
            <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400">
                <span class="material-symbols-outlined text-[20px]">payments</span>
            </div>
        </div>
        <p class="text-2xl font-black text-emerald-400">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>

    <!-- Stat 2: Total Pesanan -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 shadow-xl hover:border-indigo-500/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Total Pesanan</span>
            <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400">
                <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
            </div>
        </div>
        <p class="text-2xl font-black text-white">{{ number_format($totalPesanan) }}</p>
    </div>

    <!-- Stat 3: Pesanan Selesai -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 shadow-xl hover:border-cyan-500/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Pesanan Selesai</span>
            <div class="w-10 h-10 bg-cyan-500/10 rounded-xl flex items-center justify-center text-cyan-400">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
            </div>
        </div>
        <p class="text-2xl font-black text-cyan-400">{{ number_format($pesananSelesai) }}</p>
    </div>

    <!-- Stat 4: Pesanan Dibatalkan -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 shadow-xl hover:border-red-500/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Pesanan Dibatalkan</span>
            <div class="w-10 h-10 bg-red-500/10 rounded-xl flex items-center justify-center text-red-400">
                <span class="material-symbols-outlined text-[20px]">cancel</span>
            </div>
        </div>
        <p class="text-2xl font-black text-red-400">{{ number_format($pesananDibatalkan) }}</p>
    </div>
</div>

<!-- Sales Chart Card -->
<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 shadow-xl mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-semibold text-white">Grafik Penjualan</h3>
            <p class="text-xs text-slate-500 mt-0.5">Pendapatan dan volume transaksi pesanan</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="bg-[#121220] border border-outline-variant/30 rounded-xl p-0.5 flex">
                <button class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200" id="btnBulanan" onclick="loadChart('bulanan')">Bulanan</button>
                <button class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200" id="btnHarian" onclick="loadChart('harian')">Harian (30 Hari)</button>
            </div>
            <select class="bg-[#121220] border border-outline-variant/30 rounded-xl px-3 py-1.5 text-slate-300 text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none cursor-pointer" id="filterTahun" onchange="loadChart('bulanan')">
                @for($y = now()->year; $y >= now()->year - 2; $y--)
                <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>
    
    <div class="h-[340px] relative w-full">
        <canvas id="salesChart"></canvas>
    </div>
    
    <div class="flex items-center justify-center gap-6 mt-6">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
            <span class="text-xs text-slate-400">Pendapatan (Rp)</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
            <span class="text-xs text-slate-400">Jumlah Pesanan</span>
        </div>
    </div>
</div>

<!-- Tables Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Table 1: Produk Terlaris -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
            <h3 class="text-base font-semibold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-400 text-[20px]">trending_up</span>
                Produk Terlaris
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#24243a]">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-16">#</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right w-32">Qty Terjual</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right w-40">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkTerlaris as $i => $p)
                    <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                        <td class="px-6 py-4 text-[13px] text-slate-500 font-mono">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 text-[13px] font-medium text-white">{{ $p['name'] }}</td>
                        <td class="px-6 py-4 text-[13px] text-slate-300 text-right font-semibold">{{ $p['qty'] }}</td>
                        <td class="px-6 py-4 text-[13px] text-emerald-400 text-right font-semibold">Rp {{ number_format($p['revenue'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 text-[13px]">
                            <div class="flex flex-col items-center gap-2 py-4">
                                <span class="material-symbols-outlined text-[40px] opacity-10">inbox</span>
                                <span>Belum ada data penjualan produk</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 2: Pesanan Per Status -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden flex flex-col justify-between">
        <div>
            <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-400 text-[20px]">pie_chart</span>
                    Pesanan Per Status
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#24243a]">
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right w-32">Jumlah</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right w-32">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananPerStatus as $ps)
                        <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                            <td class="px-6 py-4">
                                @php
                                    $bc = [
                                        'menunggu' => 'bg-blue-500/15 text-blue-400 border-blue-500/20',
                                        'dikonfirmasi' => 'bg-amber-500/15 text-amber-400 border-amber-500/20',
                                        'dikemas' => 'bg-purple-500/15 text-purple-400 border-purple-500/20',
                                        'dikirim' => 'bg-cyan-500/15 text-cyan-400 border-cyan-500/20',
                                        'diperjalanan' => 'bg-orange-500/15 text-orange-400 border-orange-500/20',
                                        'selesai' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20',
                                        'dibatalkan' => 'bg-red-500/15 text-red-400 border-red-500/20'
                                    ];
                                    $bl = [
                                        'menunggu' => 'Menunggu',
                                        'dikonfirmasi' => 'Dikonfirmasi',
                                        'dikemas' => 'Dikemas',
                                        'dikirim' => 'Dikirim',
                                        'diperjalanan' => 'Dalam Perjalanan',
                                        'selesai' => 'Selesai',
                                        'dibatalkan' => 'Dibatalkan'
                                    ];
                                @endphp
                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full border {{ $bc[$ps->status] ?? 'bg-slate-500/15 text-slate-400' }}">{{ $bl[$ps->status] ?? strtoupper($ps->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-white font-semibold text-right">{{ $ps->total }}</td>
                            <td class="px-6 py-4 text-[13px] text-slate-400 text-right">{{ $totalPesanan > 0 ? round(($ps->total / $totalPesanan) * 100, 1) : 0 }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-500 text-[13px]">
                                <div class="flex flex-col items-center gap-2 py-4">
                                    <span class="material-symbols-outlined text-[40px] opacity-10">inbox</span>
                                    <span>Belum ada data status pesanan</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($pesananPerStatus->count() > 0)
        <div class="px-6 py-5 border-t border-outline-variant/10">
            <div class="flex items-center gap-1.5 h-3.5 rounded-full overflow-hidden bg-[#121220] p-0.5 border border-outline-variant/10">
                @foreach($pesananPerStatus as $ps)
                @php
                $pct = $totalPesanan > 0 ? ($ps->total / $totalPesanan) * 100 : 0;
                $colors = [
                    'menunggu' => '#3b82f6',
                    'dikonfirmasi' => '#f59e0b',
                    'dikemas' => '#a855f7',
                    'dikirim' => '#06b6d4',
                    'diperjalanan' => '#f97316',
                    'selesai' => '#10b981',
                    'dibatalkan' => '#ef4444'
                ];
                $color = $colors[$ps->status] ?? '#64748b';
                @endphp
                <div style="width:{{ $pct }}%; background:{{ $color }};" class="h-full first:rounded-l-full last:rounded-r-full transition-all duration-500" title="{{ $bl[$ps->status] ?? $ps->status }}: {{ round($pct,1) }}%"></div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('additional-js')
<script>
(() => {
// Chart.js CDN
if (!window.Chart) {
    var s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js';
    document.head.appendChild(s);
    s.onload = function(){ 
        loadChart('bulanan'); 
    };
} else {
    loadChart('bulanan');
}

var salesChart = null;

function loadChart(tipe) {
    const btnBulanan = document.getElementById('btnBulanan');
    const btnHarian = document.getElementById('btnHarian');
    const isBulanan = tipe === 'bulanan';
    
    if (isBulanan) {
        btnBulanan.className = 'px-4 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white shadow-md transition-all duration-200';
        btnHarian.className = 'px-4 py-1.5 rounded-lg text-xs font-semibold text-slate-400 hover:text-slate-200 transition-all duration-200';
    } else {
        btnBulanan.className = 'px-4 py-1.5 rounded-lg text-xs font-semibold text-slate-400 hover:text-slate-200 transition-all duration-200';
        btnHarian.className = 'px-4 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white shadow-md transition-all duration-200';
    }

    var tahun = document.getElementById('filterTahun').value;
    var url = '{{ route("admin.laporan.chart") }}?tipe=' + tipe + '&tahun=' + tahun;

    fetch(url)
        .then(function(r){ return r.json() })
        .then(function(res) {
            var ctx = document.getElementById('salesChart').getContext('2d');
            if (salesChart) salesChart.destroy();

            salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: res.labels,
                    datasets: [
                        {
                            label: 'Pendapatan',
                            data: res.data.map(function(d){ return d.pendapatan }),
                            backgroundColor: 'rgba(99, 102, 241, 0.25)',
                            borderColor: '#6366f1',
                            borderWidth: 2,
                            borderRadius: 6,
                            yAxisID: 'y',
                            order: 2
                        },
                        {
                            label: 'Pesanan',
                            data: res.data.map(function(d){ return d.pesanan }),
                            type: 'line',
                            borderColor: '#22d3ee',
                            backgroundColor: 'rgba(34, 211, 238, 0.1)',
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#22d3ee',
                            tension: 0.3,
                            yAxisID: 'y1',
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1c1c2d',
                            borderColor: 'rgba(46,46,72,0.5)',
                            borderWidth: 1,
                            titleColor: '#e2e8f0',
                            bodyColor: '#94a3b8',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(ctx) {
                                    if (ctx.dataset.label === 'Pendapatan') return 'Pendapatan: Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                    return 'Pesanan: ' + ctx.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: 'rgba(46,46,72,0.1)' }, ticks: { color: '#64748b', font: { size: 11 } } },
                        y: {
                            position: 'left',
                            grid: { color: 'rgba(46,46,72,0.1)' },
                            ticks: {
                                color: '#64748b', font: { size: 11 },
                                callback: function(v) {
                                    if (v >= 1000000) return 'Rp ' + (v / 1000000).toFixed(1) + 'jt';
                                    if (v >= 1000) return 'Rp ' + (v / 1000).toFixed(0) + 'rb';
                                    return 'Rp ' + v;
                                }
                            }
                        },
                        y1: { position: 'right', grid: { display: false }, ticks: { color: '#64748b', font: { size: 11 }, stepSize: 1 } }
                    }
                }
            });
            
            // Fix scroll setelah chart selesai digambar
            setTimeout(forceScrollFix, 100);
        });
}

function toggleCustom() {
    var v = document.getElementById('filterPeriode').value;
    var cr = document.getElementById('customRange');
    if (v === 'custom') {
        cr.classList.remove('hidden');
        cr.classList.add('flex');
    } else {
        cr.classList.add('hidden');
        cr.classList.remove('flex');
        applyFilter();
    }
}

function applyFilter() {
    var periode = document.getElementById('filterPeriode').value;
    var params = new URLSearchParams();
    params.set('periode', periode);
    if (periode === 'custom') {
        params.set('dari', document.getElementById('filterDari').value);
        params.set('sampai', document.getElementById('filterSampai').value);
    }
    window.location.href = '{{ route("admin.laporan") }}?' + params.toString();
}

// Expose functions to window for inline HTML event handlers
window.loadChart = loadChart;
window.toggleCustom = toggleCustom;
window.applyFilter = applyFilter;
})();
</script>
@endsection