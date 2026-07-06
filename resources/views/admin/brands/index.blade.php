@extends('layouts.admin')

@section('title', 'Data Merek')

@section('content')
<div class="flex gap-6 items-start">

    <!-- Tabel Kiri -->
    <div class="flex-1 min-w-0">
    <section class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center gap-3 flex-shrink-0">
            <h2 class="text-[16px] font-semibold text-white">Data Merek</h2>
            <span class="bg-indigo-600 text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[24px] h-[24px] flex items-center justify-center" id="brand-count">0</span>
        </div>

        <div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 flex-shrink-0">
            <div class="flex items-center gap-2 text-slate-400 text-[13px]">
                <span>Show</span>
                <select class="bg-[#121220] border border-outline-variant/30 rounded-md px-3 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none text-[13px]">
                    <option>10</option><option>25</option><option>50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-slate-400 text-[13px]">Search:</span>
                <input class="bg-[#121220] border border-outline-variant/30 rounded-md px-4 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none w-[200px] text-[13px] placeholder-slate-600" type="text" placeholder="Cari merek..." id="search-brand"/>
            </div>
        </div>

        <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#24243a] border-b border-outline-variant/30">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Merek</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Opsi</th>
                    </tr>
                </thead>
                <tbody id="brand-tbody">
                    <tr>
                        <td class="px-6 py-12 text-center text-slate-500 text-[13px]" colspan="4">
                            <div class="flex flex-col items-center gap-2 py-8">
                                <span class="material-symbols-outlined text-[48px] opacity-10 animate-pulse">progress_activity</span>
                                <span>Memuat data...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    </div>

    <!-- Form Kanan -->
    <div class="w-96 flex-shrink-0">
    <aside class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden sticky top-20 p-6 h-full flex flex-col">
        <h2 class="text-[16px] font-semibold text-white mb-6 flex items-center gap-2 flex-shrink-0">
            <span class="material-symbols-outlined text-[18px] text-indigo-400">add_circle</span>
            Tambah Merek
        </h2>
        <form id="brand-form" class="space-y-5 flex-1 flex flex-col">
            @csrf
            <input type="hidden" id="edit-id" value=""/>
            <div class="space-y-2">
                <label class="block text-[12px] text-slate-400 uppercase font-bold" for="brand-name">Nama Merek <span class="text-red-400">*</span></label>
                <input class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]" id="brand-name" placeholder="Masukkan nama merek" required type="text"/>
            </div>
            <div class="flex gap-2 mt-auto pt-6">
                <button id="cancel-edit" class="hidden flex-1 bg-[#2a2a40] hover:bg-[#333350] text-slate-300 text-[13px] font-semibold py-3 rounded-lg transition-colors" type="button">Batal</button>
                <button id="submit-btn" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white text-[13px] font-semibold py-3 rounded-lg transition-colors shadow-lg shadow-indigo-500/20 active:scale-[0.98] flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span id="submit-text">Tambah</span>
                </button>
            </div>
        </form>
    </aside>
    </div>

</div>

<script>
(() => {
var sampleBrands=[
    {id:1,name:'Nike',slug:'nike',image_url:'https://picsum.photos/seed/nike-s/100/100.jpg'},
    {id:2,name:'Adidas',slug:'adidas',image_url:'https://picsum.photos/seed/adidas-s/100/100.jpg'},
    {id:3,name:'Puma',slug:'puma',image_url:'https://picsum.photos/seed/puma-s/100/100.jpg'},
    {id:4,name:'New Balance',slug:'new-balance',image_url:'https://picsum.photos/seed/nb-s/100/100.jpg'},
    {id:5,name:'Reebok',slug:'reebok',image_url:'https://picsum.photos/seed/reebok-s/100/100.jpg'},
    {id:6,name:'Converse',slug:'converse',image_url:'https://picsum.photos/seed/converse-s/100/100.jpg'},
    {id:7,name:'Vans',slug:'vans',image_url:'https://picsum.photos/seed/vans-s/100/100.jpg'},
    {id:8,name:'Asics',slug:'asics',image_url:'https://picsum.photos/seed/asics-s/100/100.jpg'},
    {id:9,name:'Skechers',slug:'skechers',image_url:'https://picsum.photos/seed/skechers-s/100/100.jpg'},
    {id:10,name:'Fila',slug:'fila',image_url:'https://picsum.photos/seed/fila-s/100/100.jpg'}
];

var API='/admin/api/brands';
var brandTbody=document.getElementById('brand-tbody');
var brandCount=document.getElementById('brand-count');
var brandForm=document.getElementById('brand-form');
var editIdField=document.getElementById('edit-id');
var cancelBtn=document.getElementById('cancel-edit');
var submitBtn=document.getElementById('submit-btn');
var submitText=document.getElementById('submit-text');

function slugify(s){return s.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'')}

function renderBrands(d){
    brandCount.textContent=d.length;
    if(!d.length){
        brandTbody.innerHTML='<tr><td class="px-6 py-12 text-center text-slate-500 text-[13px]" colspan="4"><div class="flex flex-col items-center gap-2 py-8"><span class="material-symbols-outlined text-[48px] opacity-10">category</span><span>Tidak ada data merek</span></div></td></tr>';
        return;
    }
    brandTbody.innerHTML=d.map(function(b,i){
        return '<tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">'
            +'<td class="px-6 py-4 text-[13px] text-slate-400">'+(i+1)+'</td>'
            +'<td class="px-6 py-4 text-[13px] text-white font-medium">'+b.name+'</td>'
            +'<td class="px-6 py-4 text-[13px] text-slate-400">'+b.slug+'</td>'
            +'<td class="px-6 py-4"><div class="flex gap-2">'
            +'<button onclick="editBrand('+b.id+',\''+b.name.replace(/'/g,"\\'")+'\')" class="p-2 rounded-lg bg-purple-500/10 text-purple-400 hover:text-white hover:bg-purple-500/20 transition-all" title="Edit"><span class="material-symbols-outlined text-[16px]">edit</span></button>'
            +'<button onclick="deleteBrand('+b.id+',\''+b.name.replace(/'/g,"\\'")+'\')" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Hapus"><span class="material-symbols-outlined text-[16px]">delete</span></button>'
            +'</div></td></tr>';
    }).join('');
}

function loadBrands(s){
    s=s||'';
    var token=document.querySelector('meta[name="csrf-token"]');
    var headers={'Accept':'application/json'};
    if(token) headers['X-CSRF-TOKEN']=token.content;
    fetch(API+(s?'?search='+s:''),{headers:headers})
    .then(function(r){if(!r.ok) throw new Error('HTTP '+r.status);return r.json()})
    .then(function(d){
        if(Array.isArray(d)&&d.length){sampleBrands=d;renderBrands(d)}
        else{var f=sampleBrands.filter(function(b){return !s||b.name.toLowerCase().includes(s.toLowerCase())});renderBrands(f)}
    })
    .catch(function(){var f=sampleBrands.filter(function(b){return !s||b.name.toLowerCase().includes(s.toLowerCase())});renderBrands(f)});
}

var st;
document.getElementById('search-brand').addEventListener('input',function(e){
    clearTimeout(st);
    st=setTimeout(function(){var q=e.target.value.toLowerCase();var f=sampleBrands.filter(function(b){return b.name.toLowerCase().includes(q)});renderBrands(f);loadBrands(e.target.value)},400);
});

brandForm.addEventListener('submit',async function(e){
    e.preventDefault();
    var isEdit=editIdField.value!=='';
    var nameVal=document.getElementById('brand-name').value.trim();
    var bHTML=submitBtn.innerHTML;
    submitBtn.disabled=true;
    submitBtn.innerHTML='<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span> Menyimpan...';
    
    var url=isEdit?API+'/'+editIdField.value:API;
    var token=document.querySelector('meta[name="csrf-token"]');
    var h={
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    };
    if(token) h['X-CSRF-TOKEN']=token.content;
    
    try{
        var res=await fetch(url,{
            method: isEdit ? 'PUT' : 'POST',
            headers: h,
            body: JSON.stringify({ name: nameVal })
        });
        var data=await res.json();
        if(res.ok||res.status===201){
            showToast(data.message||(isEdit?'Merek diperbarui':'Merek ditambahkan'),'success');
            if(!isEdit){sampleBrands.push({id:data.id||Date.now(),name:nameVal,slug:slugify(nameVal)});renderBrands(sampleBrands)}
            else{for(var i=0;i<sampleBrands.length;i++){if(String(sampleBrands[i].id)===String(editIdField.value)){sampleBrands[i].name=nameVal;sampleBrands[i].slug=slugify(nameVal);break}}renderBrands(sampleBrands)}
            resetForm();loadBrands();
        }else{showToast(data.message||'Gagal menyimpan','error')}
    }catch(err){console.error('submit error:',err);showToast('Terjadi kesalahan koneksi','error')}
    submitBtn.disabled=false;submitBtn.innerHTML=bHTML;
});

function editBrand(id,name){
    editIdField.value=id;document.getElementById('brand-name').value=name;
    submitText.textContent='Simpan';cancelBtn.classList.remove('hidden');
    submitBtn.querySelector('.material-symbols-outlined').textContent='save';
    window.scrollTo({top:0,behavior:'smooth'});
}

function deleteBrand(id,name){
    if(!confirm('Yakin hapus merek "'+name+'"?'))return;
    var token=document.querySelector('meta[name="csrf-token"]');
    var headers={'Accept':'application/json'};if(token) headers['X-CSRF-TOKEN']=token.content;
    fetch(API+'/'+id,{method:'DELETE',headers:headers})
    .then(function(r){return r.json()})
    .then(function(d){
        if(d.message){showToast(d.message,'success');sampleBrands=sampleBrands.filter(function(b){return String(b.id)!==String(id)});renderBrands(sampleBrands);loadBrands()}
        else showToast('Gagal menghapus','error');
    })
    .catch(function(){showToast('Terjadi kesalahan','error')});
}

function resetForm(){
    brandForm.reset();editIdField.value='';
    submitText.textContent='Tambah';cancelBtn.classList.add('hidden');submitBtn.querySelector('.material-symbols-outlined').textContent='add';
}

cancelBtn.addEventListener('click',resetForm);

function showToast(m,t){
    var toast=document.createElement('div');
    toast.className='fixed top-6 right-6 z-[100] px-5 py-3 rounded-xl text-[13px] font-medium shadow-xl transition-all transform translate-x-full '+(t==='success'?'bg-emerald-600 text-white':'bg-red-600 text-white');
    toast.textContent=m;document.body.appendChild(toast);
    requestAnimationFrame(function(){toast.classList.remove('translate-x-full');toast.classList.add('translate-x-0')});
    setTimeout(function(){toast.classList.remove('translate-x-0');toast.classList.add('translate-x-full');setTimeout(function(){toast.remove()},300)},3000);
}

window.editBrand = editBrand;
window.deleteBrand = deleteBrand;

renderBrands(sampleBrands);
loadBrands();
})();
</script>
@endsection