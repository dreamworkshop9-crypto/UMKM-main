<header class="sticky top-0 z-20 bg-slate-900/80 backdrop-blur-md border-b border-slate-700/50 px-8 py-4 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold text-white">@yield('page-title', 'Dashboard')</h2>
        <p class="text-xs text-slate-500 mt-0.5">Panel Administrasi</p>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-slate-400">Halo, <strong class="text-white">{{ auth()->user()->name }}</strong></span>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 text-sm bg-slate-800 hover:bg-red-500/20 hover:text-red-400 text-slate-400 rounded-lg border border-slate-700/50 transition-colors">Keluar</button>
        </form>
    </div>
</header>
