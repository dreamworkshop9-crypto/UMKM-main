<?php $__env->startSection('title', 'Data User'); ?>

<?php $__env->startSection('content'); ?>
<style>
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
}
.modal-overlay.show { opacity: 1; pointer-events: auto; }
.modal-box {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.5);
    border-radius: 0.75rem;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(20px) scale(0.97);
    transition: transform 0.25s;
    position: relative;
    z-index: 10000;
}
.modal-overlay.show .modal-box { transform: translateY(0) scale(1); }

.modal-input {
    width: 100%;
    background: #121220;
    border: 1px solid rgba(46, 46, 72, 0.5);
    border-radius: 0.5rem;
    padding: 10px 14px;
    color: #e3e0f5;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
}
.modal-input:focus { border-color: rgba(99, 102, 241, 0.5); }
</style>

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-white">Data Pelanggan</h1>
        <p class="text-[12px] text-slate-500 mt-1">Kelola data pelanggan terdaftar</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/10 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Total Pelanggan</p>
                <p class="text-2xl font-bold text-white mt-1"><?php echo e(number_format($totalUsers)); ?></p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-indigo-400 text-[20px]">group</span>
            </div>
        </div>
    </div>
    <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/10 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Pelanggan Aktif</p>
                <p class="text-2xl font-bold text-emerald-400 mt-1"><?php echo e(number_format($activeUsers)); ?></p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-400 text-[20px]">verified</span>
            </div>
        </div>
    </div>
    <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/10 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Pelanggan Baru (Bulan Ini)</p>
                <p class="text-2xl font-bold text-amber-400 mt-1"><?php echo e(number_format($newUsersMonth)); ?></p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-400 text-[20px]">person_add</span>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden shadow-xl">
    
    <!-- Controls (Search & Filters) -->
    <div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[18px] text-slate-500">search</span>
                <input type="text" id="searchInput" placeholder="Cari nama atau email..." value="<?php echo e(request('search')); ?>" autocomplete="off" class="bg-[#121220] border border-outline-variant/30 rounded-lg py-2 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none w-[280px]">
            </div>
            <button type="button" onclick="resetFilters()" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white border border-outline-variant/30 hover:border-slate-500 transition-all">Reset</button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#24243a] border-b border-outline-variant/30">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Pelanggan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No. Telepon</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tgl Daftar</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                    <td class="px-6 py-4 text-[13px] text-slate-500"><?php echo e(($users->currentPage() - 1) * $users->perPage() + $i + 1); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=6366f1&color=fff&size=32" class="w-8 h-8 rounded-full" alt=""/>
                            <span class="text-[13px] font-medium text-white"><?php echo e($user->name); ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-[13px] text-slate-300"><?php echo e($user->email); ?></td>
                    <td class="px-6 py-4 text-[13px] text-slate-300"><?php echo e($user->phone ?? '-'); ?></td>
                    <td class="px-6 py-4 text-[13px] text-slate-400"><?php echo e($user->created_at ? $user->created_at->format('d M Y') : '-'); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" class="p-1.5 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Hapus" onclick="confirmDelete(<?php echo e($user->id); ?>, '<?php echo e($user->name); ?>')">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                        <div class="flex flex-col items-center gap-2 py-8">
                            <span class="material-symbols-outlined text-[48px] opacity-10">person_off</span>
                            <span class="text-[13px]">Tidak ada data pelanggan ditemukan</span>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($users->hasPages()): ?>
    <div class="px-6 py-4 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <p class="text-[13px] text-slate-500">Showing <?php echo e($users->firstItem() ?? 0); ?> to <?php echo e($users->lastItem() ?? 0); ?> of <?php echo e($users->total()); ?> entries</p>
        <div class="flex flex-wrap gap-1">
            <a href="<?php echo e($users->appends(request()->query())->previousPageUrl() ?? '#'); ?>" class="px-4 py-2 border border-outline-variant/30 bg-[#212135] text-slate-400 rounded-l-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors <?php echo e($users->onFirstPage() ? 'opacity-40 pointer-events-none' : ''); ?>">Previous</a>
            <a href="<?php echo e($users->appends(request()->query())->nextPageUrl() ?? '#'); ?>" class="px-4 py-2 border border-l-0 border-outline-variant/30 bg-[#212135] text-slate-400 rounded-r-lg text-[13px] hover:bg-[#2a2a30] hover:text-white transition-colors <?php echo e($users->hasMorePages() ? '' : 'opacity-40 pointer-events-none'); ?>">Next</a>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Modal Delete -->
<div class="modal-overlay" id="modalDelete">
    <div class="modal-box" style="max-width: 400px;">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-red-400 text-[28px]">warning</span>
            </div>
            <h3 class="text-[15px] font-semibold text-white mb-2">Hapus Pelanggan?</h3>
            <p class="text-[13px] text-slate-400">Pelanggan "<span id="deleteName" class="text-white font-medium"></span>" akan dihapus secara permanen.</p>
        </div>
        <form method="POST" action="" id="formDelete">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="flex items-center gap-3 px-6 py-4 border-t border-outline-variant/30">
                <button type="button" onclick="closeModal('modalDelete')" class="flex-1 px-4 py-2.5 rounded-lg text-[13px] font-medium text-slate-400 hover:text-white border border-outline-variant/30 hover:border-slate-500 transition-all text-center">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg text-[13px] font-semibold text-white bg-red-600 hover:bg-red-500 transition-all text-center">Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
(() => {

// Search & Filter
var searchTimeout;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function(){ applyFilters() }, 400);
});

function applyFilters() {
    var params = new URLSearchParams();
    var search = document.getElementById('searchInput').value.trim();
    if (search) params.set('search', search);
    window.location.href = '<?php echo e(route("admin.users")); ?>' + (params.toString() ? '?' + params.toString() : '');
}

function resetFilters() {
    window.location.href = '<?php echo e(route("admin.users")); ?>';
}

// Modal
function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('show');
    document.body.style.overflow = '';
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay') && e.target.classList.contains('show')) {
        closeModal(e.target.id);
    }
});

// Delete User
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('formDelete').action = '<?php echo e(route("admin.users.destroy", ":id")); ?>'.replace(':id', id);
    openModal('modalDelete');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.show').forEach(function(m){ closeModal(m.id) });
    }
});

// Expose to window for inline HTML onclick handlers
window.applyFilters = applyFilters;
window.resetFilters = resetFilters;
window.openModal = openModal;
window.closeModal = closeModal;
window.confirmDelete = confirmDelete;
})();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKM/UMKM-main/resources/views/admin/users.blade.php ENDPATH**/ ?>