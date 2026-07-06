@extends('layouts.admin')

@php
    $statusMap = [
        'masuk'          => ['label'=>'Masuk',        'dot'=>'bg-slate-500',        'text'=>'text-slate-400',     'bg'=>'bg-slate-500',   'text'=>'text-slate-300',   'icon'=>'fa-inbox',        'next'=>'konfirmasi',      'nextLabel'=>'Konfirmasi'],
        'konfirmasi'       => ['label'=>'Konfirmasi',    'dot'=>'bg-sky-500',         'text'=>'text-sky-400',     'bg'=>'bg-sky-500',     'text'=>'text-sky-300',   'icon'=>'fa-clipboard-check','next'=>'dalam-perjalanan','nextLabel'=>'Proses'];
        'dalam-perjalanan'=> ['label'=>'Dalam Perjalanan','dot'=>'bg-amber-500','text'=>'text-amber-400','bg'=>'bg-amber-500','text'=>'text-amber-300','icon'=>'fa-truck-moving','next'=>'dikemas',       'nextLabel'=>'Proses'];
        'dikemas'         => ['label'=>'Dikemas',       'dot'=>'bg-purple-500','text'=>'text-purple-400','bg'=>'bg-purple-500',   'text'=>'text-purple-300','icon':'fa-box',           'next'=>'dikirim',         'nextLabel'=>'Kirim'];
        'next-dikirim'     => ['label'=>'Dikirim',     'dot'=>'bg-cyan-500',        'text'=>'text-cyan-400',     'bg'=>'bg-cyan-500',     'text'=>'text-cyan-300',   'icon'=>'fa-truck-fast',  'next'=>'selesai',          'nextLabel'=>'Selesai'];
        'selesai'        => ['label'=>'Selesai',      'dot'=>'bg-emerald-500','text'=>'text-emerald-400',  'bg'=>'bg-emerald-500',  'text'=>'text-emerald-300','icon'=>'fa-circle-check',      'next'=>null,          'nextLabel'=>null];
    ];
@endsection

@section('title', $statusMap[$status]['label'].' - SALZA')
@section('page-title', $statusMap[$status]['label'])

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.row-hover{transition:background .15s,box-shadow .15s}
.row-hover:hover{background:rgba(14,116,54,.06);box-shadow:inset 3px 0 0 #0e734a3}
@keyframes toastIn{from{opacity:0;transform:translateX(100%)}to{opacity:1;transform:0} to{opacity:1;transform:translateX(0)}}
@keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(100%)}}
.toast-in{animation:toastIn .3s ease forwards}
.toast-out{animation:toastOut .25s ease forwards}
</style>
@endsection

@section('content')
<div class="flex gap-6 items-start">

    <!-- Tabel Pesanan -->
    <div class="flex-1 min-w-0">
        <div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-{{ $statusMap[$status]['bg'] }} flex items-center justify-center shadow-sm {{ $statusMap[$status]['shadow'] }}">
                        <i class="fa-solid {{ $statusMap[$status]['icon'] }} text-xs text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">Pesanan {{ $statusMap[$status]['label'] }}</h2>
                        <p class="text-xs text-slate-500">Menampilkan <span id="orderCount" class="font-semibold text-white">0</span> pesanan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari invoice / nama..." class="inp-focus w-60 pl-9 pr-4 py-2.5 text-sm bg-slate-50 border border-panel-border rounded-xl font-medium placeholder:text-slate-400" aria-label="Cari pesanan">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </div>
                    </div>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/60 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                            <th class="px-5 py-3 w-12">No.</th>
                            <th class="px-5 py-3">Invoice</th>
                            <th class="px-5 py-3">Nama Pemesan</th>
                            <th class="px-5 py-3 text-right">Total</th>
                            <th class="px-5 py-3">Metode</th>
                            <th class="px-5 py-3 w-28 text-center">Status</th>
                            <th class="px-5 py-3 w-28 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody" class="divide-y divide-slate-700/50">
                        <tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <i class="fa-solid fa-spinner fa-spin text-xl mb-2"></i>
                            <p class="text-sm">Memuat data...</p>
                        </td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer paginasi -->
            <div class="px-6 py-3.5 border-t border-panel-border bg-slate-50/40 flex items-center justify-between">
                <p class="text-xs text-slate-500">Menampilkan <span id="showingCount" class="text-slate-300 font-semibold">0</span> data</p>
                <div class="flex items-center gap-1" id="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Form Proses Status -->
    @if($statusMap[$status]['next'])
    <aside class="w-96 flex-shrink-0 anim-slide-up" style="animation-delay:.08s">
        <div class="bg-dashboard-card rounded-xl border border-panel-border shadow-sm overflow-hidden sticky top-24">
            <div class="px-6 border-b border-panel-border flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-{{ $statusMap[$status]['bg'] }} flex items-center justify-center shadow-sm {{ $statusMap[$status]['shadow'] }}">
                    <i class="fa-solid {{ $statusMap[$status]['icon'] }} text-xs text-white"></i>
                </div>
                <h3 class="text-sm font-bold text-white">Proses Pesanan</h3>
            </div>

            <form id="processForm" class="p-6 space-y-5" novalidate>
                <!-- Info pesanan terpilih -->
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/50">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Pesanan Terpilih</p>
                    <p id="selectedInfo" class="text-sm text-slate-400">Belum ada pesanan dipilih</p>
                </div>

                <!-- Tombol Proses -->
                <button type="submit" id="processBtn" class="btn-act w-full py-3 bg-{{ $statusMap[$status]['bg'] }} hover:brightness-110 text-white text-sm font-bold rounded-xl shadow-md shadow-{{ $statusMap[$status]['shadow'] }} hover:shadow-lg hover:brightness-125 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid {{ $statusMap[$status]['icon'] }} text-xs"></i>
                    <span>{{ $statusMap[$status]['nextLabel'] }}</span>
                </button>

                <!-- Jumlah terpilih -->
                <div class="flex items-center justify-between px-1 mt-3">
                    <span class="text-[11px] font-semibold text-slate-500">Terpilih: <span id="selectedCount" class="text-white font-bold">0</span> pesanan</span>
                </div>
            </form>
        </div>
    @endif

<script>
const STATUS_MAP = {
    'masuk':          {label:'Masuk',        dot:'bg-slate-500',text:'text-slate-400',bg:'bg-slate-500',text:'text-slate-300',icon:'fa-inbox',       shadow:'shadow-slate-500/30',next:'konfirmasi',      nextLabel:'Konfirmasi'},
    'konfirmasi':       {label:'Konfirmasi',     dot:'bg-sky-500',text:'text-sky-400',bg:'bg-sky-500',text:'text-sky-300',icon:'fa-clipboard-check', shadow:'shadow-sky-500/30',next:'dalam-perjalanan',nextLabel:'Proses'},
    'dalam-perjalanan': {label:'Dalam Perjalanan',dot:'bg-amber-500',text:'text-amber-400',bg:'bg-amber-500',text:'text-amber-300',icon:'fa-truck-moving',shadow:'shadow-amber-500/30',next:'dikemas',       nextLabel:'Proses'},
    'dikemas':         {label:'Dikemas',       dot:'bg-purple-500',text:'text-purple-400',bg:'bg-purple-500',text:'text-purple-300',icon:'fa-box',           shadow:'shadow-purple-500/30',next:'dikirim',         nextLabel:'Kirim'},
    'next-dikirim':     {label:'Dikirim',     dot:'bg-cyan-500',text:'text-cyan-400',bg:'bg-cyan-500',text:'text-cyan-300',icon:'fa-truck-fast',  shadow:'shadow-cyan-500/30',next:'selesai',          nextLabel:'Selesai'},
    'selesai':        {label:'Selesai',      dot:'bg-emerald-500',text:'text-emerald-400',bg:'bg-emerald-500',text:'text-emerald-300',icon:'fa-circle-check',  shadow:'shadow-emerald-500/30',next:null,              nextLabel:null},
};

const currentStatus = '{{ $status }}';
const API = {
    list:   '{{ route("orders.list") }}',
    update:  id => `{{ route("orders.update", "ID") }}`.replace('ID', id),
    delete: id => `{{ route("orders.destroy", "ID") }}`.replace('letORDID', id),
    statuses: '{{ route("pesanan.masuk") }',
};

let items=[], currentPage=1, PER_PAGE=5, selectedIds=[], deleteTargetId=null;

function showToast(msg,type='success'){
    let c=document.getElementById('toastContainer');
    if(!c){c=document.createElement('div');c.id='toastContainer';c.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none';document.body.appendChild(c)}
    const icons={success:'fa-circle-check text-emerald-400',error:'fa-circle-xmark text-red-400',info:'fa-circle-info text-sky-400'};
    const el=document.createElement('div');
    el.className='toast-in pointer-events-auto flex items-center gap-3 px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px]';
    el.innerHTML=`<i class="fa-solid ${icons[type]}"></i><span class="text-sm font-semibold text-white flex-1">${msg}</span>`;
    c.appendChild(el);setTimeout(()=>{el.classList.replace('toast-in','toast-out');setTimeout(()=>el.remove(),250)},3000);
}

async function fetchData(search=''){
    try{const url=`${API.status}?status=${currentStatus}${search?'&search='+encodeURIComponent(search):API.list}?status=${currentStatus}`;const r=await fetch(url);if(!r.ok)throw new Error();items=await r.json();renderTable(search)}
    catch(e){showToast('Gagal memuat data','error')}
}

function renderTable(filter=''){
    const f=items.filter(b=>b.invoice.toLowerCase().includes(filter.toLowerCase())||b.customer_name.toLowerCase().includes(filter.toLowerCase()));
    const tp=Math.max(1,const tp=Math.ceil(f.length/PER_PAGE));if(currentPage>tp)currentPage=tp;
    const s=(currentPage-1)*PER_PAGE,pd=f.slice(s,s+PER_PAGE),tb=document.getElementById('orderTableBody');tb.innerHTML='';
    if(!pd.length){tb.innerHTML='<tr><td colspan="7" class="px-6 py-12 text-center text-slate-500"><div class="flex flex-col items-center"><i class="fa-solid fa-box-open text-3xl text-slate-600 mb-2"></i><p class="text-sm text-slate-500">Tidak ada pesanan di sini</p></div></td></tr>';return;}
    pd.forEach((o,i)=>{
        const sm = STATUS_MAP[currentStatus];
        const dot = sm.dot;
        const bg = sm.bg;
        const txt = sm.text;
        const isExpired = o.status==='dalam-perjalanan' && o.valid_until && new Date(o.valid_until) < new Date();
        let statusText = o.status==='dikirim' ? 'Dikirim' : o.status;
        // Override jika tidak aktif
        if(o.status==='dikirim' && isExpired) statusText = 'Expired';
        if(o.status==='selesai') statusText = 'Selesai';

        const tr=document.createElement('tr');tr.className='row-hover';
        tr.innerHTML=`
            <td class="px-5 py-3 text-sm text-slate-500">${s+i+1}</td>
            <td class="td px-5 py-3"><span class="font-mono text-[12px] font-semibold text-slate-300">${o.invoice}</span></td>
            <td class="px-5 py-3 text-sm text-slate-300">${o.customer_name}</td>
            <td class="td py-3 text-sm font-semibold text-white text-right">Rp${Number(o.total).toLocaleString('id-ID')}</td>
            <td class="td py-3 text-sm text-slate-400">${o.payment_method}</td>
            <td class="td py-3 text-center">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold ${bg} ${txt}">
                    <span class="w-1.5 h-1.5 rounded-full ${dot}"></span>
                    ${statusText}
                </span>
            </td>
            <td class="td py-3 text-center"><div class="flex items-center justify-center gap-1.5">
                <button onclick="openEdit(${o.id})" class="w-8 h-8 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 flex items-center justify-center text-amber-400 hover:text-amber-300 transition-colors" title="Edit"><i class="fa-solid fa-pen text-xs"></i></button>
                <button onclick="openDelete(${o.id})" class="w-8 h-8 rounded-lg bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center text-red-400 hover:text-red-300 transition-colors" title="Hapus"><i class="fa-solid fa-trash-can text-xs"></i></button>
            </div></td>`;
        tb.appendChild(tr);
    });
    document.getElementById('orderCount').textContent=items.length;
    document.getElementById('showingCount').textContent=f.length;
    document.getElementById('selectedCount').textContent=selectedIds.length;

    // Paginasi
    const pg=document.getElementById('pagination');pg.innerHTML='';
    if(tp>1){
        const mk=(h,c,fn)=>{const b=document.createElement('button');b.className=c;b.innerHTML=h;b.onclick=fn;pg.appendChild(b)};
        mk('<i class="fa-solid fa-chevron-left text-[10px"></i>','w-8 h-8 rounded-lg border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===1?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage--;renderTable(filter)});
        for(let p=1;p<=tp;p++)mk(p,p===currentPage?'w-8 h-8 rounded-lg bg-{{sm.bg}} text-white flex items-center justify-center text-xs font-bold shadow-sm {{sm.shadow}}" style="background:{{sm.bg}};color:#fff" >'+p+'</button>'
            :'w-8 h-8 rounded-lg border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:text-white',()=>{currentPage=p;renderTable(filter)});
        mk('<i class="fa-solid fa-chevron-right text-[10px"></i>','w-8 h-8 rounded-lg border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===tp?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage++;renderTable(filter)});
    }
}

// Cek semua row
function checkRows(){
    document.querySelectorAll('#orderTableBody .row-hover input[type=checkbox]').forEach(cb=>{
        cb.addEventListener('change',()=>{
            if(cb.checked) selectedIds.push(parseInt(cb.value));else selectedIds=selectedIds.filter(x=>x!==parseInt(cb.value));
            document.getElementById('selectedCount').textContent=selectedIds.length;
            updateProcessBtn();
        });
    });
}

// Update tombol proses
function updateProcessBtn(){
    const btn=document.getElementById('processBtn');
    if(selectedIds.length===0){
        btn.disabled=true;btn.classList.add('opacity-40','pointer-events-none');return;
    }
    btn.disabled=false;btn.classList.remove('opacity-40','pointer-events-none');
}

// Buka modal edit
function openEdit(id){
    const o=items.find(x=>x.id===id);if(!o)return;
    document.getElementById('editId').value=id;
    document.getElementById('editInvoice').value=o.invoice;
    document.getElementById('editName').value=o.customer_name;
    document.getElementById('editTotal').value=o.total;
    document.getElementById('editPayment').value=o.payment_method;
    document.getElementById('editStatus').value=o.status;
    document.getElementById('editShadow').style.background=`${STATUS_MAP[o.status]?.shadow || ''}`;
    document.getElementById('editIcon').className=`w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs ${STATUS_MAP[o.status]?.bg || ''} ${STATUS_MAP[o.status]?.shadow || ''}`;
    document.getElementById('editStatusLabel').textContent=STATUS_MAP[o.status]?.label||'';
    document.getElementById('editStatusDot').className=`w-1.5 h-1.5 rounded-full ${STATUS_MAP[o.status]?.dot || ''}`;
    document.getElementById('editStatusActive').style.display= '';
    document.getElementById('editStatusExpired').style.display=o.status==='dikirim'&&new Date(o.valid_until)<new Date()?'':'none';
    document.getElementById('editStatusText').textContent=o.status==='dikirim'&&new Date(o.valid_until)<new Date()?'Expired':'Aktif';

    document.getElementById('editModal').classList.remove('hidden');
}
function closeEditModal(){document.getElementById('editModal').classList.add('hidden')}
document.getElementById('closeEditBtn').onclick=closeEditModal;
document.getElementById('cancelEditBtn').onclick=closeEditModal';
document.getElementById('editOverlay').onclick=closeEditModal;

document.getElementById('editForm').addEventListener('submit',async e=>{
    e.preventDefault();
    try{
        const id=parseInt(document.getElementById('editId').value);
        const status=document.querySelector('input[name="newStatus"]:checked').value;
        const r=await fetch(API.update(id),{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}','Content-Type':'application/json'},body:JSON.stringify({status})});
        if(!r.ok)throw new Error();
        const d=await r.json();closeEditModal();showToast(d.message);
        // Update UI tanpa reload, tapi juga cek apakah row sudah pindah halaman
        const row=document.querySelector(`input[value="${id}"]`);
        if(!row){await fetchData()}else{row.closest('.row-hover').querySelector('.status-badge').dataset.newStatus=status}
    }catch(err){showToast('Gagal mengubah status','error')}
});

// Hapus
function openDelete(id){const o=items.find(x=>x.id===id);if(!o)return;deleteTargetId=id;document.getElementById('deleteName').textContent=o.invoice;document.getElementById('deleteModal').classList.remove('hidden')}
function closeDeleteModal(){document.getElementById('deleteModal').classList.add('hidden');deleteTargetId=null}
document.getElementById('cancelDeleteBtn').onclick=closeDeleteModal;
document.getElementById('deleteOverlay').onclick=closeDeleteModal;
document.getElementById('confirmDeleteBtn').addEventListener('click',async()=>{
    if(deleteTargetId===null)return;
    const btn=document.getElementById('confirmDeleteBtn');btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>';
    try{const r=await fetch(API.delete(deleteTargetId),{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}','Content-Type':'application/json'},body:JSON.stringify({_method:'DELETE'})});
    if(!r.ok)throw new Error();
    const d=await r.json();closeDeleteModal();showToast(d.message,'info');await fetchData();}
    catch(err){showToast('Gagal menghapus','error')}
    finally{btn.disabled=false;btn.innerHTML='Hapus'}
});

// Cek status diubah tanpa reload
function checkStatus(id,newStatus){
    const row=document.querySelector(`input[value="${id}]);
    if(!row)return;
    const badge=row.closest('.status-badge');
    const sm=STATUS_MAP[newStatus]||STATUS_MAP['masuk'];
    if(badge){
        badge.className=`inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold ${sm.bg} ${sm.text}`;
        const dot=document.createElement('span');
        dot.className=`w-1. let-[1.5h-[6px] rounded-full ${sm.dot}`;
        badge.prepend(dot);
        badge.querySelector('.status-text').textContent=sm.label==='Expired'&&new Date(items.find(x=>x.id)?.valid_until)<new Date()?'Expired':'Aktif';
    }
}

document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeEditModal();closeDeleteModal()}});
fetchData();
@endsection
