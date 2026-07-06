@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header Page -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-white">Pengaturan Profil</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui data nama, email, dan kata sandi akun administrator Anda.</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl flex items-center gap-3 text-emerald-400">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Alert Errors -->
    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-rose-400">
        <div class="flex items-center gap-3 mb-2 font-semibold text-sm">
            <span class="material-symbols-outlined text-[20px]">error</span>
            <span>Terjadi kesalahan pengisian form:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-1 pl-1">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Profile Edit Card -->
    <div class="bg-surface-container rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center gap-3">
            <span class="material-symbols-outlined text-indigo-400 text-[20px]">admin_panel_settings</span>
            <h2 class="text-[15px] font-semibold text-white">Detail Akun</h2>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-500 text-[20px]">person</span>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="w-full bg-[#121220] border border-outline-variant/30 rounded-xl pl-12 pr-4 py-3 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-300">
                </div>
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-500 text-[20px]">mail</span>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full bg-[#121220] border border-outline-variant/30 rounded-xl pl-12 pr-4 py-3 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-300">
                </div>
            </div>

            <div class="border-t border-outline-variant/10 pt-6">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-1">Ubah Kata Sandi</h3>
                <p class="text-[11px] text-slate-500 mb-4">Biarkan kosong jika Anda tidak ingin mengubah kata sandi saat ini.</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-400 mb-2">Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-500 text-[20px]">lock</span>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                   class="w-full bg-[#121220] border border-outline-variant/30 rounded-xl pl-12 pr-4 py-3 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-300">
                        </div>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-400 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-500 text-[20px]">lock</span>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi"
                                   class="w-full bg-[#121220] border border-outline-variant/30 rounded-xl pl-12 pr-4 py-3 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-300">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 border-t border-outline-variant/10 pt-6">
                <a href="{{ route('admin.dashboard') }}" onclick="event.preventDefault(); navigateTo('{{ route('admin.dashboard') }}')"
                   class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700/50 hover:bg-slate-700 hover:text-white transition-all duration-300">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white transition-all duration-300 shadow-lg shadow-indigo-500/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
