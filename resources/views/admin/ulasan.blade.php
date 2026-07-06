@extends('layouts.admin')

@section('title', 'Ulasan')

@section('content')
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">

    <!-- Header -->
    <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-yellow-500/15 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-yellow-400 text-[20px]">reviews</span>
            </div>
            <div>
                <h2 class="text-[16px] font-semibold text-white">Ulasan Pelanggan</h2>
                <p class="text-[12px] text-slate-500">Kelola ulasan produk dari pelanggan</p>
            </div>
        </div>
        <span class="bg-yellow-500 text-[#121220] text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[24px] h-[24px] flex items-center justify-center">{{ $ulasan->total() }}</span>
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
            <input id="searchInput" class="bg-[#121220] border border-outline-variant/30 rounded-md px-4 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none w-[200px] text-[13px] placeholder-slate-600" type="text" placeholder="Cari ulasan / nama..." value="{{ request('search') }}"/>
        </div>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#24243a] border-b border-outline-variant/30">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pesanan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ulasan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @if($ulasan->count() > 0)
                    @foreach($ulasan as $index => $item)
                    <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                        <td class="px-6 py-4 text-[13px] text-slate-400">
                            {{ ($ulasan->currentPage() - 1) * $ulasan->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-[13px] text-slate-300 whitespace-nowrap">
                            {{ $item->created_at->format('d M Y') }}
                            <span class="block text-[11px] text-slate-500">{{ $item->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[13px] text-slate-200">{{ $item->user->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[13px] text-indigo-400 font-mono">{{ $item->pesanan->code ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-[16px] {{ $i <= ($item->rating ?? 0) ? 'text-yellow-400' : 'text-slate-600' }}" style="font-variation-settings: 'FILL' {{ $i <= ($item->rating ?? 0) ? '1' : '0' }};">star</span>
                                @endfor
                                <span class="text-[11px] text-slate-500 ml-1">({{ $item->rating ?? 0 }})</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-[13px] text-slate-300 max-w-[300px] truncate">{{ $item->review ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusCfg = [
                                    'aktif'   => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20',
                                    'nonaktif' => 'bg-red-500/15 text-red-400 border-red-500/20',
                                ];
                                $statusLabel = ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'];
                            @endphp
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $statusCfg[$item->status] ?? 'bg-slate-500/15 text-slate-400' }}">
                                {{ $statusLabel[$item->status] ?? $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1.5">
                                @if($item->status === 'aktif')
                                <button onclick="toggleStatus({{ $item->id }}, 'nonaktif')" class="p-1.5 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Nonaktifkan">
                                    <span class="material-symbols-outlined text-[16px]">visibility_off</span>
                                </button>
                                @else
                                <button onclick="toggleStatus({{ $item->id }}, 'aktif')" class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:text-white hover:bg-emerald-500/20 transition-all" title="Aktifkan">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                </button>
                                @endif
                                <button onclick="hapusUlasan({{ $item->id }})" class="p-1.5 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Hapus">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="px-6 py-16 text-center" colspan="8">
                            <div class="flex flex-col items-center gap-2 py-8">
                                <span class="material-symbols-outlined text-[48px] text-yellow-500/10">reviews</span>
                                <p class="text-slate-500 text-[14px]">Belum ada ulasan</p>
                                <p class="text-slate-600 text-[12px]">Ulasan dari pelanggan akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <p class="text-[13px] text-slate-500">Showing {{ $ulasan->firstItem() ?? 0 }} to {{ $ulasan->lastItem() ?? 0 }} of {{ $ulasan->total() }} entries</p>
        <div class="flex">
            <a href="{{ $ulasan->appends(request()->query())->previousPageUrl() ?? '#' }}" class="px-4 py-2 border border-outline-variant/30 bg-[#212135] text-slate-400 rounded-l-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $ulasan->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">Previous</a>
            <a href="{{ $ulasan->appends(request()->query())->nextPageUrl() ?? '#' }}" class="px-4 py-2 border border-l-0 border-outline-variant/30 bg-[#212135] text-slate-400 rounded-r-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $ulasan->hasMorePages() ? '' : 'opacity-40 pointer-events-none' }}">Next</a>
        </div>
    </div>

</div>
@endsection

@section('additional-js')
<script>
(() => {
// Search
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

// Per page
document.getElementById('perPage').addEventListener('change', function(e) {
    const p = new URLSearchParams(location.search);
    p.set('per_page', e.target.value);
    p.delete('page');
    location.href = location.pathname + '?' + p.toString();
});

// Toggle status
function toggleStatus(id, status) {
    const label = status === 'aktif' ? 'aktifkan' : 'nonaktifkan';
    if (!confirm('Yakin ' + label + ' ulasan ini?')) return;

    fetch('{{ route("admin.ulasan.update-status", ":id") }}'.replace(':id', id), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: status })
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast('Gagal mengubah status', 'error');
        }
    })
    .catch(() => showToast('Terjadi kesalahan', 'error'));
}

// Hapus
function hapusUlasan(id) {
    if (!confirm('Yakin hapus ulasan ini?')) return;

    fetch('{{ route("admin.ulasan.destroy", ":id") }}'.replace(':id', id), {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast('Gagal menghapus', 'error');
        }
    })
    .catch(() => showToast('Terjadi kesalahan', 'error'));
}

// Toast
function showToast(m, t) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-6 right-6 z-[100] px-5 py-3 rounded-xl text-[13px] font-medium shadow-xl transition-all transform translate-x-full ' + (t === 'success' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white');
    toast.textContent = m;
    document.body.appendChild(toast);
    requestAnimationFrame(() => { toast.classList.remove('translate-x-full'); toast.classList.add('translate-x-0'); });
    setTimeout(() => { toast.classList.remove('translate-x-0'); toast.classList.add('translate-x-full'); setTimeout(() => toast.remove(), 300); }, 3000);
}

// Expose to window for inline HTML onclick handlers
window.toggleStatus = toggleStatus;
window.hapusUlasan = hapusUlasan;
window.showToast = showToast;
})();
</script>
@endsection