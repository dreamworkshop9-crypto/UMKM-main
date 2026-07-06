<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>@yield('title', 'Salza Admin') - Admin</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config={darkMode:"class",theme:{extend:{colors:{background:"#121220","surface-container":"#1c1c2d",primary:"#6366f1",secondary:"#a855f7","outline-variant":"#2e2e48","on-surface":"#94a3b8",error:"#ef4444"},borderRadius:{DEFAULT:"0.25rem",lg:"0.5rem",xl:"0.75rem",full:"9999px"},spacing:{gutter:"20px",xl:"32px",sm:"8px",md:"16px",lg:"24px",unit:"4px",xs:"4px",sidebar_width:"260px"},fontFamily:{"body-md":["Inter"],"display-lg":["Inter"],"body-sm":["Inter"],"title-sm":["Inter"],"headline-md":["Inter"],"label-caps":["Inter"]}}}}
</script>
<style>
body{background-color:#121220;color:#e3e0f5}
.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24}
.custom-scrollbar::-webkit-scrollbar{width:4px}
.custom-scrollbar::-webkit-scrollbar-track{background:#1C1C2D}
.custom-scrollbar::-webkit-scrollbar-thumb{background:#2D2D3F;border-radius:10px}
.bg-active-gradient{background:linear-gradient(90deg,#3b82f6 0%,#8b5cf6 100%)}
</style>
@yield('additional-css')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body class="font-body-md text-body-md bg-background">
<div id="spa-loading-bar" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-300 z-[100] w-0 opacity-0"></div>

<!-- Sidebar -->
<aside id="sidebar" class="w-[260px] h-screen fixed left-0 top-0 bg-[#1c1c2d] flex flex-col z-[60] border-r border-outline-variant/20 transition-all duration-300">
<div class="p-6">
<h1 class="text-2xl font-black tracking-tighter text-white">SALZA</h1>
<p class="text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500 mt-1">Admin Management</p>
</div>
<nav class="flex-1 px-4 overflow-y-auto custom-scrollbar space-y-1">

<!-- Dashboard -->
<a class="flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'bg-active-gradient text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all" href="{{ route('admin.dashboard') }}">
<span class="material-symbols-outlined text-[20px]">dashboard</span>
<span class="text-[13px] {{ request()->routeIs('admin.dashboard') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
</a>

<!-- Data Master -->
<div class="px-4 py-2 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Data Master</div>
<a class="flex items-center justify-between {{ request()->routeIs('admin.brands.index') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.brands.index') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">list</span><span class="text-[13px] font-medium">Merek</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.kategori') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.kategori') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">category</span><span class="text-[13px] font-medium">Kategori</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.produk') || request()->routeIs('admin.produk.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.produk') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span class="text-[13px] font-medium">Produk</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.shipping.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.shipping.index') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">local_shipping</span><span class="text-[13px] font-medium">Pengiriman</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>


<!-- Kelola Pesanan -->
<div class="px-4 py-3 mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Kelola Pesanan</div>

{{-- Pesanan Parent (POLOS, klik toggle) --}}
<div onclick="togglePesanan()" class="flex items-center justify-between {{ request()->routeIs('admin.pesanan.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all cursor-pointer select-none">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-[20px]">list_alt</span>
<span class="text-[13px] font-medium">Pesanan</span>
</div>
<span id="pesanan-arrow" class="material-symbols-outlined text-[16px] transition-transform duration-200 {{ request()->routeIs('admin.pesanan.*') ? '' : '' }}" style="{{ request()->routeIs('admin.pesanan.*') ? 'transform:rotate(180deg)' : '' }}">expand_more</span>
</div>

{{-- Sub-menu Pesanan --}}
<div id="pesanan-submenu" class="pl-6 space-y-1 mt-1 mb-1 {{ request()->routeIs('admin.pesanan.*') ? '' : 'hidden' }}">
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.masuk') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.masuk') }}">
<span class="material-symbols-outlined text-[14px]">{{ request()->routeIs('admin.pesanan.masuk') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Masuk</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.dikonfirmasi') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikonfirmasi') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.dikonfirmasi') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.dikonfirmasi') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Di Konfirmasi</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.dikemas') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikemas') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.dikemas') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.dikemas') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Di Kemas</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.dikirim') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.dikirim') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.dikirim') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.dikirim') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Dikirim</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.diperjalanan') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.diperjalanan') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.diperjalanan') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.diperjalanan') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Dalam Perjalanan</span>
</a>
<a class="flex items-center gap-3 {{ request()->routeIs('admin.pesanan.selesai') ? 'text-white font-medium' : 'text-slate-400 hover:text-white' }} px-4 py-2 rounded-lg text-[12px] transition-all" href="{{ route('admin.pesanan.selesai') }}">
<span class="material-symbols-outlined text-[14px] {{ request()->routeIs('admin.pesanan.selesai') ? '' : 'text-indigo-400/50' }}">{{ request()->routeIs('admin.pesanan.selesai') ? 'arrow_forward' : 'more_horiz' }}</span><span>Pesanan Selesai</span>
</a>
</div>

<a class="flex items-center justify-between {{ request()->routeIs('admin.pembatalan') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.pembatalan') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">cancel</span><span class="text-[13px] font-medium">Pembatalan</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.pengembalian') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.pengembalian') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">assignment_return</span><span class="text-[13px] font-medium">Pengembalian</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.ulasan') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.ulasan') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">reviews</span><span class="text-[13px] font-medium">Ulasan</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.stok') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.stok') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">inventory</span><span class="text-[13px] font-medium">Stok Produk</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>

<!-- Pengaturan -->
<div class="px-4 py-3 mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-widest">Pengaturan</div>
<a class="flex items-center justify-between {{ request()->routeIs('admin.users') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.users') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">group</span><span class="text-[13px] font-medium">Data Pelanggan</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.payment.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.payment.index') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">payments</span><span class="text-[13px] font-medium">Metode Pembayaran</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
<a class="flex items-center justify-between {{ request()->routeIs('admin.laporan') ? 'text-white' : 'text-slate-400 hover:text-white' }} px-4 py-2.5 rounded-lg transition-all group" href="{{ route('admin.laporan') }}">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">bar_chart</span><span class="text-[13px] font-medium">Laporan</span></div>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
</a>
</nav>
</aside>

<!-- Main Content -->
<main id="main-content" class="pl-[260px] min-h-screen flex flex-col transition-all duration-300">
<!-- Header -->
<header class="h-[70px] flex justify-between items-center px-8">
<div class="flex items-center gap-6">
<span class="material-symbols-outlined text-slate-400 cursor-pointer" onclick="toggleSidebar()">menu</span>
<span class="material-symbols-outlined text-slate-400 cursor-pointer" onclick="toggleFullscreen()">fullscreen</span>
</div>
<div class="flex items-center gap-6">
    <!-- Notification Badge -->
    <div id="admin-notification-badge" class="relative cursor-pointer group flex items-center justify-center mr-2">
        <a href="{{ route('admin.pesanan.masuk') }}" onclick="event.preventDefault(); navigateTo('{{ route('admin.pesanan.masuk') }}')">
            <span class="material-symbols-outlined hover:text-white text-[22px] text-slate-400">mail</span>
        </a>
        @if(($pendingOrdersCount ?? 0) > 0)
            <span class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] px-1 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white shadow-lg shadow-rose-500/40">
                {{ $pendingOrdersCount }}
            </span>
        @endif
    </div>

    <!-- Profile Dropdown Container -->
    <div class="relative">
        <button id="admin-profile-btn" onclick="toggleAdminProfileDropdown()" class="flex items-center gap-2 focus:outline-none group">
            <img alt="Profile" class="w-8 h-8 rounded-full border border-indigo-500/30 object-cover hover:border-indigo-400 transition-all" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=6366f1&color=fff"/>
            <span class="text-xs text-slate-400 group-hover:text-white transition-colors font-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
            <span class="material-symbols-outlined text-[16px] text-slate-500 group-hover:text-white transition-colors">expand_more</span>
        </button>
        
        <!-- Dropdown Menu -->
        <div id="admin-profile-dropdown" class="hidden absolute right-0 mt-2.5 w-48 bg-[#1c1c2d] border border-outline-variant/30 rounded-xl shadow-2xl z-[70] py-1.5 overflow-hidden">
            <div class="px-4 py-2 border-b border-outline-variant/30">
                <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-[10px] text-slate-500 truncate mt-0.5">{{ Auth::user()->email ?? 'admin@salza.com' }}</p>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" onclick="event.preventDefault(); navigateTo('{{ route('admin.dashboard') }}'); closeAdminProfileDropdown()" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-300 hover:text-white hover:bg-slate-700/50 transition-colors">
                <span class="material-symbols-outlined text-[16px]">dashboard</span>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.profile.edit') }}" onclick="event.preventDefault(); navigateTo('{{ route('admin.profile.edit') }}'); closeAdminProfileDropdown()" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-300 hover:text-white hover:bg-slate-700/50 transition-colors">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Edit Profil</span>
            </a>

            <div class="border-t border-outline-variant/30 mt-1.5 pt-1.5">
                <form method="POST" action="{{ route('logout') }}" id="dropdown-logout-form">
                    @csrf
                    <button type="button" onclick="if(confirm('Apakah Anda yakin ingin keluar?')) document.getElementById('dropdown-logout-form').submit()" class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-xs text-rose-400 hover:bg-rose-500/10 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</header>

<!-- Content Area -->
<div id="admin-content-area" class="flex-1 p-8">

{{-- Flash Message --}}
@if(session('success'))
<div id="flash-msg" class="max-w-[1200px] mx-auto mb-4 px-5 py-3 rounded-xl bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 text-[13px] font-medium flex items-center gap-2">
<span class="material-symbols-outlined text-[18px]">check_circle</span>{{ session('success') }}
</div>
@endif
@if(session('error'))
<div id="flash-msg" class="max-w-[1200px] mx-auto mb-4 px-5 py-3 rounded-xl bg-red-600/20 border border-red-500/30 text-red-400 text-[13px] font-medium flex items-center gap-2">
<span class="material-symbols-outlined text-[18px]">error</span>{{ session('error') }}
</div>
@endif

<div id="admin-dynamic-content">
@yield('content')
</div>

</div>

<!-- Footer -->
<footer class="px-8 py-6 flex justify-between items-center text-[11px] text-slate-500">
<div>&copy; {{ date('Y') }} <span class="text-indigo-400">Salza E-commerce</span>. All Rights Reserved.</div>
<div>Versi / <span class="text-white">1.1</span></div>
</footer>
</main>

<script>
const flash=document.getElementById('flash-msg');
if(flash){setTimeout(()=>{flash.style.transition='opacity .4s,transform .4s';flash.style.opacity='0';flash.style.transform='translateY(-10px)';setTimeout(()=>flash.remove(),400)},4000)}
function togglePesanan(){const s=document.getElementById('pesanan-submenu'),a=document.getElementById('pesanan-arrow'),h=s.classList.contains('hidden');if(h){s.classList.remove('hidden');a.style.transform='rotate(180deg)'}else{s.classList.add('hidden');a.style.transform='rotate(0deg)'}}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    if (sidebar && mainContent) {
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            mainContent.classList.add('pl-[260px]');
            mainContent.classList.remove('pl-0');
        } else {
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.remove('pl-[260px]');
            mainContent.classList.add('pl-0');
        }
    }
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(err => {
            console.error(`Error enabling fullscreen: ${err.message}`);
        });
    } else {
        document.exitFullscreen();
    }
}

function toggleAdminProfileDropdown() {
    const dropdown = document.getElementById('admin-profile-dropdown');
    if (dropdown) dropdown.classList.toggle('hidden');
}

function closeAdminProfileDropdown() {
    const dropdown = document.getElementById('admin-profile-dropdown');
    if (dropdown) dropdown.classList.add('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const btn = document.getElementById('admin-profile-btn');
    const dropdown = document.getElementById('admin-profile-dropdown');
    if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

// === LIGHTWEIGHT SPA ROUTER ===
async function navigateTo(url, push = true) {
    const loader = document.getElementById('spa-loading-bar');
    if (loader) {
        loader.style.width = '0%';
        loader.style.opacity = '1';
        setTimeout(() => { if (loader.style.opacity === '1') loader.style.width = '70%'; }, 50);
    }
    
    try {
        const response = await fetch(url);
        if (!response.ok) {
            window.location.href = url;
            return;
        }
        
        const html = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Swap content
        const newContent = doc.getElementById('admin-dynamic-content');
        const currentContent = document.getElementById('admin-dynamic-content');
        if (newContent && currentContent) {
            currentContent.innerHTML = newContent.innerHTML;
        } else {
            window.location.href = url;
            return;
        }
        
        // Swap notification badge
        const newBadge = doc.getElementById('admin-notification-badge');
        const currentBadge = document.getElementById('admin-notification-badge');
        if (newBadge && currentBadge) {
            currentBadge.innerHTML = newBadge.innerHTML;
        }
        
        // Swap title
        document.title = doc.title;
        
        // Update URL
        if (push) {
            history.pushState(null, '', url);
        }
        
        // Update active sidebar styles
        updateActiveSidebar(url);
        
        // Re-execute page-specific scripts
        executePageScripts(doc);
        
        // Scroll page back to top
        window.scrollTo({ top: 0, behavior: 'instant' });
        
    } catch (error) {
        console.error('SPA navigation failed:', error);
        window.location.href = url;
    } finally {
        if (loader) {
            loader.style.width = '100%';
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => { loader.style.width = '0%'; }, 300);
            }, 200);
        }
    }
}

function updateActiveSidebar(targetUrl) {
    const parsedUrl = new URL(targetUrl);
    const path = parsedUrl.pathname;
    
    const sidebarLinks = document.querySelectorAll('aside nav a');
    sidebarLinks.forEach(link => {
        const hrefAttr = link.getAttribute('href');
        if (!hrefAttr) return;
        
        const linkUrl = new URL(hrefAttr, window.location.origin);
        const linkPath = linkUrl.pathname;
        
        const isActive = (path === linkPath) || 
                         (linkPath !== '/admin/dashboard' && path.startsWith(linkPath));
        
        if (linkPath === '/admin/dashboard') {
            if (isActive) {
                link.className = "flex items-center gap-3 bg-active-gradient text-white shadow-lg shadow-indigo-500/20 px-4 py-2.5 rounded-lg transition-all";
                link.querySelector('span:last-child').className = "text-[13px] font-semibold";
            } else {
                link.className = "flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all";
                link.querySelector('span:last-child').className = "text-[13px] font-medium";
            }
        } else if (link.closest('#pesanan-submenu')) {
            const spanIcon = link.querySelector('span:first-child');
            if (isActive) {
                link.className = "flex items-center gap-3 text-white font-medium px-4 py-2 rounded-lg text-[12px] transition-all";
                if (spanIcon) spanIcon.textContent = 'arrow_forward';
            } else {
                link.className = "flex items-center gap-3 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-[12px] transition-all";
                if (spanIcon) spanIcon.textContent = 'more_horiz';
            }
        } else {
            if (isActive) {
                link.className = "flex items-center justify-between text-white px-4 py-2.5 rounded-lg transition-all group";
            } else {
                link.className = "flex items-center justify-between text-slate-400 hover:text-white px-4 py-2.5 rounded-lg transition-all group";
            }
        }
    });
    
    const isPesananActive = path.includes('/admin/pesanan/');
    const submenu = document.getElementById('pesanan-submenu');
    const arrow = document.getElementById('pesanan-arrow');
    if (submenu && arrow) {
        if (isPesananActive) {
            submenu.classList.remove('hidden');
            arrow.style.transform = 'rotate(180deg)';
        } else {
            submenu.classList.add('hidden');
            arrow.style.transform = 'rotate(0deg)';
        }
    }
}

function executePageScripts(doc) {
    const dynamicContainer = doc.getElementById('admin-dynamic-content');
    if (!dynamicContainer) return;
    
    const inlineScripts = Array.from(dynamicContainer.querySelectorAll('script')).filter(s => !s.src);
    inlineScripts.forEach(s => {
        const newScript = document.createElement('script');
        let code = s.textContent;
        code = code.replace(/<script[^>]*>/gi, '').replace(/<\/script>/gi, '');
        newScript.textContent = code;
        document.body.appendChild(newScript);
        newScript.remove();
    });
}

document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;
    
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
    
    const url = new URL(href, window.location.origin);
    if (url.origin !== window.location.origin) return;
    if (!url.pathname.includes('/admin') && url.pathname !== '/admin') return;
    if (link.closest('form') || href.includes('logout')) return;
    if (link.getAttribute('onclick') && link.getAttribute('onclick').includes('togglePesanan')) return;
    
    e.preventDefault();
    navigateTo(url.href);
});

window.addEventListener('popstate', function() {
    navigateTo(window.location.href, false);
});
</script>
@yield('additional-js')
</body>
</html>