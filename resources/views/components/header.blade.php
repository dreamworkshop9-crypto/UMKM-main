<header class="h-16 bg-dashboard-card flex items-center justify-between px-6 border-b border-slate-700/50" data-purpose="main-header">
    <div class="flex items-center space-x-6">
        <button class="text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
        <button class="text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
    </div>
    <div class="flex items-center space-x-6">
        <!-- Profile Avatar -->
        <div class="flex items-center space-x-3 cursor-pointer group">
            <img alt="Admin" class="w-9 h-9 rounded-full border-2 border-slate-700 group-hover:border-purple-500 transition-all" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB2Q5llndzOq3mYu6vaegYAP48AX0Vkf6tEx2uFEiQra2TQug9GUoU0gQztVxkCY_olYaRwgL-g1P62mv0TxKfSGgT2lpa5YGC7Mhd0W-QliAb8mqxxbhy0XpEDSECvGmm1d6h3EQiX2L3hZFSnJHe-4FoH7u_AtU_qlD-ROjXgre8qp2ZiXt2Sjgq5-kQbIZOYUlHbOV-cWrtD-ojFpuTwUjzh7K-NasS-Cv-1YqHFI-imDSGu4cespzK7N6t65kXn4QGDoH0xsqma"/>
        </div>
        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="flex items-center text-slate-400 hover:text-white text-sm transition-colors">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</header>
