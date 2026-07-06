@extends('layouts.admin')

@section('title', 'Kategori - SALZA')
@section('page-title', 'Kategori')

@section('styles')
<style>
.row-hover { transition: background .15s, box-shadow .15s; }
.row-hover:hover { background: rgba(139,92,246,0.08); box-shadow: inset 3px 0 0 #a855f7; }
@keyframes toastIn { from{opacity:0;transform:translateX(100%)} to{opacity:1;transform:translateX(0)} }
@keyframes toastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(100%)} }
.toast-in { animation: toastIn .3s ease forwards; }
.toast-out { animation: toastOut .25s ease forwards; }
</style>
@endsection

@section('content')
<div class="flex gap-6 items-start">
    <!-- Tabel -->
    <div class="flex-1">
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 text-xs font-bold">K</div>
                    <h2 class="text-lg font-semibold text-white">Data Kategori</h2>
                </div>
                <p class="text-sm text-slate-500">Total <span id="kategoriCount" class="text-purple-400 font-semibold">0</span> kategori</p>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
                <table class="w-full text-left">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                            <th class="px-6 py-3 w-14">No</th>
                            <th class="px-6 py-3">Nama Kategori</th>
                            <th class="px-6 py-3">Slug</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3 w-36 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="kategoriTableBody" class="divide-y divide-slate-700/50">
                        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="inline-block w-6 h-6 border-2 border-slate-600 border-t-slate-400 rounded-full animate-spin mb-2"></div>
                            <p class="text-sm">Memuat data...</p>
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Tambah -->
    <div class="w-96 flex-shrink-0">
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 text-xs font-bold">+</div>
                <h3 class="text-sm font-bold text-white">Tambah Kategori</h3>
            </div>
            <form id="addForm" class="p-6 space-y-4" novalidate>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Kategori <span class="text-red-400">*</span></label>
                    <input type="text" id="inputName" placeholder="Masukkan nama" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                    <p id="nameError" class="text-xs text-red-400 mt-1 hidden">Nama wajib diisi</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                    <textarea id="inputDesc" rows="3" placeholder="Deskripsi kategori (opsional)" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Slug Preview</label>
                    <div class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-slate-500 truncate">
                        <span id="slugPreview" class="text-slate-400">—</span>
                    </div>
                </div>
                <button type="submit" id="submitBtn" class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-lg shadow-md shadow-purple-500/20 transition-all flex items-center justify-center gap-2">
                    + Tambah
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="editOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-slate-800 rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-white">Edit Kategori</h3>
            <button id="closeEditBtn" class="w-8 h-8 rounded-lg hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white text-lg">&times;</button>
        </div>
        <form id="editForm" class="p-6 space-y-4" novalidate>
            <input type="hidden" id="editId">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Kategori <span class="text-red-400">*</span></label>
                <input type="text" id="editName" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                <textarea id="editDesc" rows="3" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" id="cancelEditBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-lg transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="deleteOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-slate-800 rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4 text-red-500 text-2xl font-bold">!</div>
            <h3 class="text-base font-bold text-white mb-1">Hapus Kategori?</h3>
            <p class="text-sm text-slate-400">Kategori <strong id="deleteName" class="text-slate-300"></strong> akan dihapus permanen.</p>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="cancelDeleteBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg transition-all">Hapus</button>
        </div>
    </div>
</div>

<script>
(() => {
var sampleKategori = [
    { id:1,  name:'Running',       slug:'running',        description:'Sepatu untuk lari jarak pendek hingga maraton' },
    { id:2,  name:'Sneakers',      slug:'sneakers',       description:'Sepatu kasual bergaya streetwear' },
    { id:3,  name:'Basketball',    slug:'basketball',     description:'Sepatu basket dengan ankle support tinggi' },
    { id:4,  name:'Casual',        slug:'casual',         description:'Sepatu sehari-hari nyaman untuk segala kesempatan' },
    { id:5,  name:'Formal',        slug:'formal',         description:'Sepatu formal untuk ke kantor dan acara resmi' },
    { id:6,  name:'Futsal',        slug:'futsal',         description:'Sepatu indoor untuk lapangan futsal' },
    { id:7,  name:'Training',      slug:'training',       description:'Sepatu gym dan latihan multifungsi' },
    { id:8,  name:'Skateboarding', slug:'skateboarding',  description:'Sepatu skate dengan sol datar dan tahan gesek' },
    { id:9,  name:'Hiking',        slug:'hiking',         description:'Sepatu outdoor untuk mendaki dan trekking' },
    { id:10, name:'Tennis',        slug:'tennis',         description:'Sepatu tenis dengan lateral support' },
    { id:11, name:'Badminton',     slug:'badminton',      description:'Sepatu bulu tangkis ringan dan grip kuat' },
    { id:12, name:'Walking',       slug:'walking',        description:'Sepatu jalan santai untuk olahraga ringan' }
];

var API = {
    list:   '{{ route("admin.kategori.list") }}',
    store:  '{{ route("admin.kategori.store") }}',
    show:   function(id){ return '{{ route("admin.kategori.show", "ID") }}'.replace('ID', id); },
    update: function(id){ return '{{ route("admin.kategori.update", "ID") }}'.replace('ID', id); },
    delete: function(id){ return '{{ route("admin.kategori.destroy", "ID") }}'.replace('ID', id); }
};

var items = [], deleteTargetId = null, currentFilter = '';

function toSlug(t) { return t.toLowerCase().trim().replace(/[^\w\s-]/g,'').replace(/[\s_]+/g,'-').replace(/^-+|-+$/g,''); }

function showToast(msg, type) {
    type = type || 'success';
    var c = document.getElementById('toastContainer');
    if (!c) { c = document.createElement('div'); c.id='toastContainer'; c.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none'; document.body.appendChild(c); }
    var colors = { success:'border-l-4 border-emerald-500', error:'border-l-4 border-red-500', info:'border-l-4 border-sky-500' };
    var el = document.createElement('div');
    el.className = 'toast-in pointer-events-auto px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px] text-sm font-semibold text-white ' + (colors[type] || colors.success);
    el.textContent = msg;
    c.appendChild(el);
    setTimeout(function() { el.classList.replace('toast-in','toast-out'); setTimeout(function(){el.remove()},250); }, 3000);
}

async function fetchData(search) {
    if (typeof search === 'undefined') search = currentFilter;
    currentFilter = search || '';
    try {
        var url = search ? API.list + '?search=' + encodeURIComponent(search) : API.list;
        var res = await fetch(url);
        if (!res.ok) throw new Error();
        var data = await res.json();
        if (Array.isArray(data) && data.length) {
            items = data;
        } else {
            items = sampleKategori.filter(function(b){ return !search || b.name.toLowerCase().includes(search.toLowerCase()); });
        }
        renderTable(search);
    } catch(e) {
        items = sampleKategori.filter(function(b){ return !search || b.name.toLowerCase().includes(search.toLowerCase()); });
        renderTable(search);
    }
}

function renderTable(filter) {
    if (typeof filter === 'undefined') filter = currentFilter;
    var filtered = items.filter(function(b){ return b.name.toLowerCase().includes(filter.toLowerCase()) || b.slug.toLowerCase().includes(filter.toLowerCase()); });
    var tbody = document.getElementById('kategoriTableBody');
    tbody.innerHTML = '';
    if (!filtered.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">Tidak ada data.</td></tr>';
    } else {
        for (var i = 0; i < filtered.length; i++) {
            var b = filtered[i];
            var descHtml = b.description ? b.description : '<span class="italic text-slate-600">Tidak ada</span>';
            var tr = document.createElement('tr');
            tr.className = 'row-hover';
            tr.innerHTML = '<td class="px-6 py-3.5 text-sm text-slate-500">' + (i + 1) + '</td>'
                + '<td class="px-6 py-3.5 text-sm font-semibold text-white">' + b.name + '</td>'
                + '<td class="px-6 py-3.5"><span class="inline-block px-2.5 py-1 bg-slate-800 border border-slate-700/50 rounded text-[11px] font-mono text-slate-400">' + b.slug + '</span></td>'
                + '<td class="px-6 py-3.5 text-sm text-slate-400 max-w-xs truncate">' + descHtml + '</td>'
                + '<td class="px-6 py-3.5 text-center"><div class="flex items-center justify-center gap-2">'
                + '<button onclick="openEdit(' + b.id + ')" class="px-3 py-1.5 rounded-lg bg-amber-500/15 hover:bg-amber-500/30 text-amber-400 hover:text-amber-300 text-[12px] font-semibold transition-colors border border-amber-500/20">Edit</button>'
                + '<button onclick="openDelete(' + b.id + ')" class="px-3 py-1.5 rounded-lg bg-red-500/15 hover:bg-red-500/30 text-red-400 hover:text-red-300 text-[12px] font-semibold transition-colors border border-red-500/20">Hapus</button>'
                + '</div></td>';
            tbody.appendChild(tr);
        }
    }
    document.getElementById('kategoriCount').textContent = items.length;
}

document.getElementById('inputName').addEventListener('input', function(e) {
    document.getElementById('slugPreview').textContent = toSlug(e.target.value) || '—';
    if (e.target.value.trim()) document.getElementById('nameError').classList.add('hidden');
});

document.getElementById('addForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    var name = document.getElementById('inputName').value.trim();
    if (!name) { document.getElementById('nameError').classList.remove('hidden'); return; }
    var btn = document.getElementById('submitBtn');
    btn.disabled = true; btn.textContent = 'Menyimpan...';
    try {
        var res = await fetch(API.store, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name: name, description: document.getElementById('inputDesc').value.trim() })
        });
        if (!res.ok) throw new Error();
        var data = await res.json();
        showToast(data.message);
        sampleKategori.push({ id: data.id || Date.now(), name: name, slug: toSlug(name), description: document.getElementById('inputDesc').value.trim() });
        items = sampleKategori;
        renderTable(currentFilter);
        document.getElementById('inputName').value = '';
        document.getElementById('inputDesc').value = '';
        document.getElementById('slugPreview').textContent = '—';
        fetchData();
    } catch(err) { showToast('Gagal menyimpan', 'error'); }
    finally { btn.disabled = false; btn.textContent = '+ Tambah'; }
});

function openEdit(id) {
    var b = items.find(function(x){ return x.id === id; }); if (!b) return;
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = b.name;
    document.getElementById('editDesc').value = b.description || '';
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEdit() { document.getElementById('editModal').classList.add('hidden'); }
document.getElementById('closeEditBtn').onclick = closeEdit;
document.getElementById('cancelEditBtn').onclick = closeEdit;
document.getElementById('editOverlay').onclick = closeEdit;

document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    var id = parseInt(document.getElementById('editId').value);
    var name = document.getElementById('editName').value.trim();
    if (!name) return;
    try {
        var res = await fetch(API.update(id), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name: name, description: document.getElementById('editDesc').value.trim(), _method: 'PUT' })
        });
        if (!res.ok) throw new Error();
        var data = await res.json();
        for (var i = 0; i < sampleKategori.length; i++) {
            if (String(sampleKategori[i].id) === String(id)) {
                sampleKategori[i].name = name;
                sampleKategori[i].slug = toSlug(name);
                sampleKategori[i].description = document.getElementById('editDesc').value.trim();
                break;
            }
        }
        items = sampleKategori;
        renderTable(currentFilter);
        closeEdit(); showToast(data.message); fetchData();
    } catch(err) { showToast('Gagal memperbarui', 'error'); }
});

function openDelete(id) {
    var b = items.find(function(x){ return x.id === id; }); if (!b) return;
    deleteTargetId = id;
    document.getElementById('deleteName').textContent = b.name;
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDelete() { document.getElementById('deleteModal').classList.add('hidden'); deleteTargetId = null; }
document.getElementById('cancelDeleteBtn').onclick = closeDelete;
document.getElementById('deleteOverlay').onclick = closeDelete;

document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
    if (deleteTargetId === null) return;
    var btn = document.getElementById('confirmDeleteBtn');
    btn.disabled = true; btn.textContent = 'Menghapus...';
    try {
        var res = await fetch(API.delete(deleteTargetId), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ _method: 'DELETE' })
        });
        if (!res.ok) throw new Error();
        var data = await res.json();
        sampleKategori = sampleKategori.filter(function(b){ return String(b.id) !== String(deleteTargetId); });
        items = sampleKategori;
        renderTable(currentFilter);
        closeDelete(); showToast(data.message, 'info'); fetchData();
    } catch(err) { showToast('Gagal menghapus', 'error'); }
    finally { btn.disabled = false; btn.textContent = 'Hapus'; }
});

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeEdit(); closeDelete(); } });

// Expose functions to window for inline HTML onclick handlers
window.openEdit = openEdit;
window.openDelete = openDelete;

items = sampleKategori;
renderTable('');
fetchData();
})();
</script>
@endsection