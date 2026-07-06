@extends('layouts.admin')

@section('title', 'Pembatalan')

@section('content')
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">

    <!-- Header -->
    <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-500/15 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-red-400 text-[20px]">cancel</span>
            </div>
            <div>
                <h2 class="text-[16px] font-semibold text-white">Pembatalan</h2>
                <p class="text-[12px] text-slate-500">Pesanan yang dibatalkan oleh admin atau pelanggan</p>
            </div>
        </div>
        <span class="bg-red-600 text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[24px] h-[24px] flex items-center justify-center">{{ $pesanan->total() }}</span>
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
            <input id="searchInput" class="bg-[#121220] border border-outline-variant/30 rounded-md px-4 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none w-[200px] text-[13px] placeholder-slate-600" type="text" placeholder="Cari kode / nama..." value="{{ request('search') }}"/>
        </div>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#24243a] border-b border-outline-variant/30">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode Pesanan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Belanja</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @if($pesanan->count() > 0)
                    @foreach($pesanan as $index => $item)
                    <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                        <td class="px-6 py-4 text-[13px] text-slate-400">
                            {{ ($pesanan->currentPage() - 1) * $pesanan->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-[13px] text-slate-300 whitespace-nowrap">
                            {{ $item->created_at->format('d M Y') }}
                            <span class="block text-[11px] text-slate-500">{{ $item->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-red-400 font-mono font-medium">{{ $item->code }}</td>
                        <td class="px-6 py-4">
                            <div class="text-[13px] text-slate-200">{{ $item->customer_name }}</div>
                            <div class="text-[11px] text-slate-500">{{ $item->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-white font-semibold whitespace-nowrap line-through decoration-red-400/50">
                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border bg-red-500/15 text-red-400 border-red-500/20">Dibatalkan</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pesanan.show', $item->id) }}" class="p-1.5 rounded-lg bg-slate-500/10 text-slate-400 hover:text-white hover:bg-slate-500/20 transition-all" title="Detail">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="px-6 py-16 text-center" colspan="7">
                            <div class="flex flex-col items-center gap-2 py-8">
                                <span class="material-symbols-outlined text-[48px] text-red-500/10">cancel</span>
                                <p class="text-slate-500 text-[14px]">Tidak ada pesanan yang dibatalkan</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <p class="text-[13px] text-slate-500">Showing {{ $pesanan->firstItem() ?? 0 }} to {{ $pesanan->lastItem() ?? 0 }} of {{ $pesanan->total() }} entries</p>
        <div class="flex">
            <a href="{{ $pesanan->appends(request()->query())->previousPageUrl() ?? '#' }}" class="px-4 py-2 border border-outline-variant/30 bg-[#212135] text-slate-400 rounded-l-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $pesanan->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">Previous</a>
            <a href="{{ $pesanan->appends(request()->query())->nextPageUrl() ?? '#' }}" class="px-4 py-2 border border-l-0 border-outline-variant/30 bg-[#212135] text-slate-400 rounded-r-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $pesanan->hasMorePages() ? '' : 'opacity-40 pointer-events-none' }}">Next</a>
        </div>
    </div>

</div>
@endsection

@section('additional-js')
<script>
let st;
document.getElementById('searchInput').addEventListener('input', function(e) {
    clearTimeout(st);
    st = setTimeout(() => {
        const p = new URLSearchParams(location.search);
        e.target.value ? p.set('search', e.target.value) : p.delete('search');
        p.delete('page');
        location.href = location.pathname + '?' + p.toString();
    }, 500);
});

document.getElementById('perPage').addEventListener('change', function(e) {
    const p = new URLSearchParams(location.search);
    p.set('per_page', e.target.value);
    p.delete('page');
    location.href = location.pathname + '?' + p.toString();
});
</script>
@endsection