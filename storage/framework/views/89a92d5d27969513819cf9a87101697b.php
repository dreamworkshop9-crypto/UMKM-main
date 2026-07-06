<?php $__env->startSection('title', 'Detail Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1200px] mx-auto space-y-6">

    <!-- Back -->
    <a href="<?php echo e(url()->previous()); ?>" class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-[13px] transition-colors">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kiri 2/3 -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Info Produk -->
            <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
                <h2 class="text-[16px] font-semibold text-white mb-5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-indigo-400">shopping_bag</span>
                    Detail Produk
                </h2>

                <?php
                    $stok = $produk->stok ?? $produk->stock ?? 0;
                    $stokColor = $stok === 0 ? 'text-red-400' : ($stok <= 10 ? 'text-amber-400' : 'text-emerald-400');
                    $stokBg = $stok === 0 ? 'bg-red-500/15 text-red-400 border-red-500/20' : ($stok <= 10 ? 'bg-amber-500/15 text-amber-400 border-amber-500/20' : 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20');
                    $stokLabel = $stok === 0 ? 'Habis' : ($stok <= 10 ? 'Menipis' : 'Aman');
                    $nama = $produk->nama ?? $produk->name ?? '-';
                    $harga = $produk->harga ?? $produk->price ?? 0;
                    $sizes = is_array($produk->sizes) ? $produk->sizes : json_decode($produk->sizes, true) ?? [];
                    $colors = is_array($produk->colors) ? $produk->colors : json_decode($produk->colors, true) ?? [];
                    $deskripsi = $produk->description ?? '';
                ?>

                <!-- Gambar -->
                <?php if($produk->image ?? $produk->gambar): ?>
                    <div class="bg-[#121220] rounded-xl p-2 border border-outline-variant/20 inline-block w-fit">
                        <img src="<?php echo e(Storage::url($produk->image ?? $produk->gambar)); ?>" alt="<?php echo e($nama); ?>" class="max-h-[200px] rounded-lg object-contain"/>
                    </div>
                <?php else: ?>
                    <div class="bg-[#121220] rounded-xl p-8 border border-outline-variant/20 inline-flex items-center justify-center w-full min-h-[200px]">
                        <span class="material-symbols-outlined text-[48px] text-slate-600">image</span>
                    </div>
                <?php endif; ?>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                    <div class="bg-[#121220] rounded-xl p-4 border border-outline-variant-10">
                        <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Kategori</div>
                        <div class="text-[14px] text-white font-medium"><?php echo e($produk->kategori->name ?? '-'); ?></div>
                    </div>
                    <div class="bg-[#121220] rounded-xl p-4 border border-outline-variant/10">
                        <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Merek</div>
                        <div class="text-[14px] text-white font-medium"><?php echo e($produk->brand->name ?? '-'); ?></div>
                    </div>
                    <div class="bg-[#121220] rounded-xl p-4 border border-outline-variant/10">
                        <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Stok</div>
                        <div class="text-[14px] font-bold <?php echo e($stokColor); ?>"><?php echo e($stok); ?></div>
                    </div>
                    <div class="bg-[#121220] rounded-xl p-4 border border-outline-variant/10">
                        <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Status</div>
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border <?php echo e($stokBg); ?>"><?php echo e($stokLabel); ?></span>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <?php if($deskripsi): ?>
                <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
                    <h3 class="text-[15px] font-semibold text-white mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-indigo-400">description</span>
                        Deskripsi
                    </h3>
                    <p class="text-[13px] text-slate-300 leading-relaxed"><?php echo e($deskripsi); ?></p>
                </div>
            <?php endif; ?>

            <!-- Varian -->
            <?php if(count($sizes) > 0 || count($colors) > 0): ?>
                <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
                    <h3 class="text-[15px] font-semibold text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-indigo-400">style</span>
                        Varian
                    </h3>
                    <div class="grid grid-cols-2 gap-6">
                        <?php if(count($sizes) > 0): ?>
                            <div>
                                <div class="text-[11px] text-slate-500 uppercase font-bold mb-2">Ukuran</div>
                                <div class="flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="text-[12px] bg-[#121220] border border-outline-variant/20 rounded-lg px-3 py-1.5 text-slate-300"><?php echo e($s); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(count($colors) > 0): ?>
                            <div>
                                <div class="text-[11px] text-slate-500 uppercase font-bold mb-2">Warna</div>
                                <div class="flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center gap-2 bg-[#121220] border border-outline-variant/20 rounded-lg px-3 py-1.5">
                                            <div class="w-4 h-4 rounded-full border border-outline-variant/30" style="background-color: <?php echo e($c); ?>"></div>
                                            <span class="text-[12px] text-slate-300"><?php echo e($c); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Harga -->
            <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
                <h3 class="text-[15px] font-semibold text-white mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-indigo-400">payments</span>
                    Harga
                </h3>
                <div class="text-[28px] font-bold text-indigo-400">Rp <?php echo e(number_format($harga, 0, ',', '.')); ?></div>
            </div>
        </div>

        <!-- Kanan 1/3 -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
                <h3 class="text-[15px] font-semibold text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-indigo-400">info</span>
                    Informasi
                </h3>
                <div class="space-y-4">
                    <div>
                        <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">ID Produk</div>
                        <div class="text-[14px] text-white font-mono">#<?php echo e($produk->id); ?></div>
                    </div>
                    <div>
                        <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Slug</div>
                        <div class="text-[14px] text-slate-300"><?php echo e($produk->slug ?? '-'); ?></div>
                    </div>
                    <?php if($produk->created_at): ?>
                        <div>
                            <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Dibuat</div>
                            <div class="text-[14px] text-slate-300"><?php echo e($produk->created_at->format('d M Y, H:i')); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if($produk->updated_at && $produk->updated_at != $produk->created_at): ?>
                        <div>
                            <div class="text-[11px] text-slate-500 uppercase font-bold mb-1">Diperbarui</div>
                            <div class="text-[14px] text-slate-300"><?php echo e($produk->updated_at->format('d M Y, H:i')); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6">
                <h3 class="text-[15px] font-semibold text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-indigo-400">bolt</span>
                    Aksi
                </h3>
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.produk.edit', $produk->id)); ?>" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-[13px] font-semibold transition-colors shadow-lg shadow-indigo-500/20">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Produk
                    </a>
                    <button onclick="hapusProduk(<?php echo e($produk->id); ?>, '<?php echo e(str_replace("'", "\\'", $nama)); ?>')" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-600/10 border border-red-500/20 hover:bg-red-600/20 text-red-400 text-[13px] font-semibold transition-colors">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        Hapus Produk
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional-js'); ?>
<script>
function hapusProduk(id, name) {
    if (!confirm('Yakin hapus produk "' + name + '"?')) return;
    fetch('<?php echo e(route('admin.produk.destroy', ':id')); ?>'.replace(':id', id), {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            showToast(data.message, 'success');
            setTimeout(function() { window.location.href = '<?php echo e(route('admin.stok')); ?>'; }, 800);
        } else {
            showToast('Gagal menghapus', 'error');
        }
    })
    .catch(function() { showToast('Terjadi kesalahan', 'error'); });
}

function showToast(m, t) {
    var toast = document.createElement('div');
    toast.className = 'fixed top-6 right-6 z-[100] px-5 py-3 rounded-xl text-[13px] font-medium shadow-xl transition-all transform translate-x-full ' + (t === 'success' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white');
    toast.textContent = m;
    document.body.appendChild(toast);
    requestAnimationFrame(function() {
        toast.classList.remove('translate-x-full');
        toast.classList.add('translate-x-0');
    });
    setTimeout(function() {
        toast.classList.remove('translate-x-0');
        toast.classList.add('translate-x-full');
        setTimeout(function() { toast.remove(); }, 300);
    }, 3000);
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKM/UMKM-main/resources/views/admin/produk/detail.blade.php ENDPATH**/ ?>