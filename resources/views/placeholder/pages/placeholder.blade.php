@extends('layouts.admin')

@section('title', $title ?? 'Halaman')

@section('content')
<div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden p-16 text-center">
    <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center mx-auto mb-4">
        <span class="material-symbols-outlined text-indigo-400 text-[32px]">construction</span>
    </div>
    <h3 class="text-lg font-bold text-white mb-2">{{ $title }}</h3>
    <p class="text-sm text-slate-400">Halaman ini masih dalam pengembangan.</p>
</div>
@endsection