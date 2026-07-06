@extends('layouts.admin')

@section('title', $pageTitle ?? 'Pengembalian')

@section('content')
<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">
    <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
        <h2 class="text-[16px] font-semibold text-white">{{ $pageTitle ?? 'Pesanan Masuk' }}</h2>
        <span class="bg-indigo-600 text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[24px] h-[24px] flex items-center justify-center">{{ $pesanan->total() }}</span>
    </div>

    <div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-3">
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

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#24243a]">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode Pesanan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Bayar</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @if($pesanan->count() > 0)
                    @foreach($pesanan as $index => $item)
                        <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                            <td class="px-6 py-4 text-[13px] text-slate-400">{{ ($pesanan->currentPage() - 1) * $pesanan->perPage() + $index + 1 }}</td>
                            <td class="px-6 py-4 text-[13px] text-slate-300 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}<span class="block text-[11px] text-slate-500">{{ $item->created_at->format('H:i') }}</span></td>
                            <td class="px-6 py-4 text-[13px] text-indigo-400 font-mono font-medium">{{ $item->invoice }}</td>
                            <td class="px-6 py-4"><div class="text-[13px] text-slate-200">{{ $item->shipping_name }}</div><div class="text-[11px] text-slate-500">{{ $item->shipping_phone }}</div></td>
                            <td class="px-6 py-4 text-[13px] text-white font-semibold whitespace-nowrap">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $bc=['menunggu'=>'bg-blue-500/15 text-blue-400 border-blue-500/20','dikonfirmasi'=>'bg-amber-500/15 text-amber-400 border-amber-500/20','dikemas'=>'bg-purple-500/15 text-purple-400 border-purple-500/20','dikirim'=>'bg-cyan-500/15 text-cyan-400 border-cyan-500/20','diperjalanan'=>'bg-orange-500/15 text-orange-400 border-orange-500/20','selesai'=>'bg-emerald-500/15 text-emerald-400 border-emerald-500/20','dibatalkan'=>'bg-red-500/15 text-red-400 border-red-500/20'];
                                    $bl=['menunggu'=>'Menunggu','dikonfirmasi'=>'Dikonfirmasi','dikemas'=>'Dikemas','dikirim'=>'Dikirim','diperjalanan'=>'Dalam Perjalanan','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
                                @endphp
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $bc[$item->status] ?? 'bg-slate-500/15 text-slate-400' }}">{{ $bl[$item->status] ?? strtoupper($item->status) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.pesanan.show', $item->id) }}" class="p-1.5 rounded-lg bg-slate-500/10 text-slate-400 hover:text-white hover:bg-slate-500/20 transition-all" title="Detail"><span class="material-symbols-outlined text-[16px]">visibility</span></a>
                                    @if($statusKey === 'menunggu')
                                        <form method="POST" action="{{ route('admin.pesanan.aksi.konfirmasi', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Konfirmasi {{ $item->invoice }}?')" class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:text-white hover:bg-emerald-500/20 transition-all" title="Konfirmasi"><span class="material-symbols-outlined text-[16px]">check_circle</span></button></form>
                                        <form method="POST" action="{{ route('admin.pesanan.aksi.dibatalkan', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Batalkan {{ $item->invoice }}?')" class="p-1.5 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Batalkan"><span class="material-symbols-outlined text-[16px]">cancel</span></button></form>
                                    @endif
                                    @if($statusKey === 'dikonfirmasi')
                                        <form method="POST" action="{{ route('admin.pesanan.aksi.dikemas', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Kemas {{ $item->invoice }}?')" class="p-1.5 rounded-lg bg-purple-500/10 text-purple-400 hover:text-white hover:bg-purple-500/20 transition-all" title="Kemas"><span class="material-symbols-outlined text-[16px]">inventory_2</span></button></form>
                                    @endif
                                    @if($statusKey === 'dikemas')
                                        <form method="POST" action="{{ route('admin.pesanan.aksi.dikirim', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Kirim {{ $item->invoice }}?')" class="p-1.5 rounded-lg bg-cyan-500/10 text-cyan-400 hover:text-white hover:bg-cyan-500/20 transition-all" title="Kirim"><span class="material-symbols-outlined text-[16px]">local_shipping</span></button></form>
                                    @endif
                                    @if($statusKey === 'dikirim')
                                        <form method="POST" action="{{ route('admin.pesanan.aksi.diperjalanan', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Dalam perjalanan {{ $item->invoice }}?')" class="p-1.5 rounded-lg bg-orange-500/10 text-orange-400 hover:text-white hover:bg-orange-500/20 transition-all" title="Dalam Perjalanan"><span class="material-symbols-outlined text-[16px]">directions_bike</span></button></form>
                                    @endif
                                    @if($statusKey === 'diperjalanan')
                                        <form method="POST" action="{{ route('admin.pesanan.aksi.selesai', $item->id) }}" class="inline">@csrf<button type="submit" onclick="return confirm('Selesai {{ $item->invoice }}?')" class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:text-white hover:bg-emerald-500/20 transition-all" title="Selesai"><span class="material-symbols-outlined text-[16px]">verified</span></button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="px-6 py-10 text-center text-slate-500 text-[13px]" colspan="7">
                            <div class="flex flex-col items-center gap-2 py-8">
                                <span class="material-symbols-outlined text-[48px] opacity-10">inbox</span>
                                <span>Tidak ada data pesanan</span>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

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
            location.href = location.pathname + '?' + p.toString()
        }, 500)
    });
    document.getElementById('perPage').addEventListener('change', function(e) {
        const p = new URLSearchParams(location.search);
        p.set('per_page', e.target.value);
        p.delete('page');
        location.href = location.pathname + '?' + p.toString()
    });
</script>
@endsection