<?php
    $pNama = $p->name;
    $pHarga = $p->price;
    $pGambar = $p->thumbnail_url; 
    $pKatId = $p->category->id ?? '';      // pakai ->category
    $pBrand = $p->brand->name ?? 'UMKM Lokal';
    $pStok = $p->stock;
    $pKatName = $p->category->name ?? '';  // pakai ->category
?>
<div class="product-card bg-dashboard-card rounded-2xl border border-slate-700/30 overflow-hidden card-hover img-zoom group fade-up visible" data-name="<?php echo e($pNama); ?>" data-kategori="<?php echo e($pKatId); ?>" data-umkm="<?php echo e($pBrand); ?>">
    <div class="relative overflow-hidden cursor-pointer" onclick="openProductModal('<?php echo e($p->id); ?>')">
        <?php
            $isWishlisted = false;
            if (auth()->check()) {
                $isWishlisted = auth()->user()->wishlists()->where('product_id', $p->id)->exists();
            }
        ?>
        <button onclick="event.stopPropagation(); toggleWishlist('<?php echo e($p->id); ?>')" class="absolute top-3 left-3 w-8 h-8 rounded-lg bg-slate-900/80 hover:bg-slate-800 text-slate-400 hover:text-rose-500 flex items-center justify-center transition-all duration-200 z-10" id="wishlist-btn-<?php echo e($p->id); ?>" title="Simpan ke Favorit">
            <i class="<?php echo e($isWishlisted ? 'fa-solid fa-heart text-rose-500' : 'fa-regular fa-heart'); ?>"></i>
        </button>
        <img src="<?php echo e($pGambar); ?>" alt="<?php echo e($pNama); ?>" class="w-full h-56 object-cover" onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <?php if($pStok <= 5): ?><span class="absolute top-3 left-[44px] px-2.5 py-1 bg-rose-500/90 text-white text-[10px] font-bold rounded-lg uppercase tracking-wide">Stok Terbatas</span><?php endif; ?>
        <span class="absolute top-3 right-3 px-2.5 py-1 bg-slate-900/80 text-slate-300 text-[10px] font-medium rounded-lg"><?php echo e($pKatName); ?></span>
        <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
            <button onclick="event.stopPropagation();openProductModal('<?php echo e($p->id); ?>')" class="w-full py-2 bg-white/90 backdrop-blur-sm text-slate-900 text-xs font-semibold rounded-lg hover:bg-white transition-colors">Lihat Detail</button>
        </div>
    </div>
    <div class="p-4">
        <p class="text-[11px] text-slate-500 font-medium mb-1"><?php echo e($pBrand); ?></p>
        <h3 class="text-sm font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-brand-400 transition-colors" onclick="openProductModal('<?php echo e($p->id); ?>')"><?php echo e($pNama); ?></h3>
        <div class="flex items-center gap-2 mb-3">
            <div class="flex items-center gap-0.5"><i class="fa-solid fa-star text-amber-400 text-[10px]"></i><span class="text-xs text-slate-400"><?php echo e(number_format($p->rating ?? 0, 1)); ?></span></div>
            <span class="text-slate-700">·</span>
            <span class="text-xs text-slate-500">Terjual <?php echo e($p->terjual ?? 0); ?></span>
        </div>
         <div class="flex items-center justify-between">
            <p class="text-base font-bold text-brand-400"><?php echo e('Rp ' . number_format($pHarga)); ?></p>
            <?php
                $hasOptions = (!empty($p->sizes) && count($p->sizes) > 0) || (!empty($p->colors) && count($p->colors) > 0);
            ?>
            <?php if($hasOptions): ?>
                <button onclick="event.stopPropagation();openProductModal('<?php echo e($p->id); ?>')" class="w-9 h-9 bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white rounded-lg flex items-center justify-center transition-all duration-200" title="Pilih Ukuran & Warna"><i class="fa-solid fa-plus text-sm"></i></button>
            <?php else: ?>
                <button onclick="event.stopPropagation();quickAddToCart('<?php echo e($p->id); ?>')" class="w-9 h-9 bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white rounded-lg flex items-center justify-center transition-all duration-200" title="Tambah ke Keranjang"><i class="fa-solid fa-plus text-sm"></i></button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /home/irawan/laravel/shoesmarket/UMKM/UMKM-main/resources/views/front/partials/product_card.blade.php ENDPATH**/ ?>