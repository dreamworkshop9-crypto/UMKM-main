@extends('layouts.admin')

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
.coupon-code{font-family:'Courier New',monospace;letter-spacing:1.5px}
</style>
@endsection

@section('content')
@yield('content')
@endsection

@section('scripts')
<script>
function showToast(msg,type='success'){
    let c=document.getElementById('toastContainer');
    if(!c){c=document.createElement('div');c.id='toastContainer';c.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none';document.body.appendChild(c)}
    const icons={success:'fa-circle-check text-emerald-400',error:'fa-circle-xmark text-red-400',info:'fa-circle-info text-sky-400'};
    const el=document.createElement('div');
    el.className='toast-in pointer-events-auto flex items-center gap-3 px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px]';
    el.innerHTML=`<i class="fa-solid ${icons[type]}"></i><span class="text-sm font-semibold text-white flex-1">${msg}</span>`;
    c.appendChild(el);setTimeout(()=>{el.classList.replace('toast-in','toast-out');setTimeout(()=>el.remove(),250)},3000);
}
</script>
@endsection
