@extends('layouts.admin')

@section('title', 'Stok Produk')

@section('content')
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">

    <!-- Header -->
    <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-cyan-500/15 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-cyan-400 text-[20px]">inventory</span>
            </div>
            <div>
                <h2 class="text-[16px] font-semibold text-white">Stok Produk</h2>
                <p class="text-[12px] text-slate-500">Monitor dan kelola stok semua produk</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#121220] border border-outline-variant/20">
                <span class="material-symbols-outlined text-red-400 text-[16px]">warning</span>
                <span class="text-[12px] text-red-400 font-bold" id="empty-count">0</span>
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#121220] border border-outline-variant/20">
                <span class="material-symbols-outlined text-amber-400 text-[16px]">info</span>
                <span class="text-[12px] text-amber-400 font-bold" id="low-count">0</span>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2 text-slate-400 text-[13px]">
            <span>Show</span>
            <select id="perPage" class="bg-[#121220] border border-outline-variant/30 rounded-md px-3 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none text-[13px]">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
            </select>
            <span>entries</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-slate-400 text-[13px]">Search:</span>
            <input id="searchInput" class="bg-[#121220] border border-outline-variant/30 rounded-md px-4 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none w-[200px] text-[13px] placeholder-slate-600" type="text" placeholder="Cari produk..." value="{{ request('search') }}"/>
        </div>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#24243a] border-b border-outline-variant/30">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">SKU</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalEmpty = 0;
                    $totalLow = 0;
                @endphp
                @if($produks->count() > 0)
                    @foreach($produks as $index => $item)
                        @php
                            $stok = $item->stok ?? $item->stock ?? 0;
                            $nama = $item->nama ?? $item->name ?? '-';
                            $sku = $item->sku ?? '-';
                            $harga = $item->harga ?? $item->price ?? 0;
                            if ($stok === 0) $totalEmpty++;
                            if ($stok > 0 && $stok <= 10) $totalLow++;
                            $stokColor = $stok === 0 ? 'text-red-400' : ($stok <= 10 ? 'text-amber-400' : 'text-emerald-400');
                            $stokBg = $stok === 0 ? 'bg-red-500/10 text-red-400 border-red-500/20' : ($stok <= 10 ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20');
                            $stokLabel = $stok === 0 ? 'Habis' : ($stok <= 10 ? 'Menipis' : 'Aman');
                        @endphp
                        <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                            <td class="px-6 py-4 text-[13px] text-slate-400">
                                {{ ($produks->currentPage() - 1) * $produks->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->gambar ?? $item->image)
                                        <img src="{{ Storage::url($item->gambar ?? $item->image) }}" alt="{{ $nama }}" class="w-10 h-10 rounded-lg object-cover border border-outline-variant/20"/>
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-[#121220] border border-outline-variant/20 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-[14px] text-slate-600">image</span>
                                        </div>
                                    @endif
                                    <span class="text-[13px] text-white font-medium">{{ Str::limit($nama, 40) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-slate-400 font-mono">{{ $sku }}</td>
                            <td class="px-6 py-4">
                                <span class="text-[14px] font-bold {{ $stokColor }}">{{ $stok }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $stokBg }}">{{ $stokLabel }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-white font-semibold whitespace-nowrap">
                                Rp {{ number_format($harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ url('admin/produk/detail/' . $item->id) }}" class="p-1.5 rounded-lg bg-slate-500/10 text-slate-400 hover:text-white hover:bg-slate-500/20 transition-all" title="Detail Produk">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="px-6 py-16 text-center" colspan="7">
                            <div class="flex flex-col items-center gap-2 py-8">
                                <span class="material-symbols-outlined text-[48px] text-cyan-500/10">inventory</span>
                                <p class="text-slate-500 text-[14px]">Tidak ada data produk</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <p class="text-[13px] text-slate-500">Showing {{ $produks->firstItem() ?? 0 }} to {{ $produks->lastItem() ?? 0 }} of {{ $produks->total() }} entries</p>
        <div class="flex">
            <a href="{{ $produks->appends(request()->query())->previousPageUrl() ?? '#' }}" class="px-4 py-2 border border-outline-variant/30 bg-[#212135] text-slate-400 rounded-l-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $produks->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">Previous</a>
            <a href="{{ $produks->appends(request()->query())->nextPageUrl() ?? '#' }}" class="px-4 py-2 border border-l-0 border-outline-variant/30 bg-[#212135] text-slate-400 rounded-r-lg text-[13px] hover:bg-[#2a2a30] hover:text-white transition-colors {{ $produks->hasMorePages() ? '' : 'opacity-40 pointer-events-none' }}">Next</a>
        </div>
    </div>

</div>

<script>
(() => {
    const rows = document.querySelectorAll('table tbody tr');
    let emptyCount = {{ $totalEmpty }};
    let lowCount = {{ $totalLow }};
    const emptyEl = document.getElementById('empty-count');
    const lowEl = document.getElementById('low-count');
    if (emptyEl) emptyEl.textContent = emptyCount;
    if (lowEl) lowEl.textContent = lowCount;
})();
</script>
@endsection