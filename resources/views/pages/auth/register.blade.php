@extends('layouts.auth')
@section('title','Daftar - SALZA')
@section('content')
<div class="bg-slate-800/60 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-2xl p-8">
    {{-- Logo --}}
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-white tracking-tight">SAL<span class="text-purple-400">ZA</span></h1>
        <p class="text-slate-400 text-sm mt-1">Buat Akun Baru</p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-4 py-3 rounded-xl mb-4">
        <i class="fa fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('daftar') }}" method="POST" class="space-y-4">
        @csrf
        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500"><i class="fa fa-user text-sm"></i></span>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Anda"
                    class="w-full bg-slate-700/50 border border-slate-600/50 text-white rounded-xl py-2.5 pl-10 pr-4 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all"/>
            </div>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500"><i class="fa fa-envelope text-sm"></i></span>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com"
                    class="w-full bg-slate-700/50 border border-slate-600/50 text-white rounded-xl py-2.5 pl-10 pr-4 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all"/>
            </div>
        </div>

        {{-- Telepon --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1.5">No. Telepon</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500"><i class="fa fa-phone text-sm"></i></span>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                    class="w-full bg-slate-700/50 border border-slate-600/50 text-white rounded-xl py-2.5 pl-10 pr-4 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all"/>
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500"><i class="fa fa-lock text-sm"></i></span>
                <input type="password" name="password" required placeholder="Minimal 8 karakter"
                    class="w-full bg-slate-700/50 border border-slate-600/50 text-white rounded-xl py-2.5 pl-10 pr-4 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all"/>
            </div>
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500"><i class="fa fa-lock text-sm"></i></span>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                    class="w-full bg-slate-700/50 border border-slate-600/50 text-white rounded-xl py-2.5 pl-10 pr-4 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all"/>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 shadow-lg shadow-purple-500/20 hover:shadow-purple-500/30 flex items-center justify-center gap-2">
            <i class="fa fa-user-plus"></i> Daftar
        </button>
    </form>

    {{-- Login link --}}
    <p class="text-center text-sm text-slate-400 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 font-medium transition-colors">Masuk di sini</a>
    </p>
</div>
@endsection
