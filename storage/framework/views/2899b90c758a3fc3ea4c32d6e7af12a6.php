<?php $__env->startSection('title', 'Detail Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1200px] mx-auto space-y-6">
    
    <!-- Header Banner -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-xl">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400">
                <span class="material-symbols-outlined text-[24px]">receipt_long</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white flex items-center gap-2">
                    Detail Pesanan
                    <span class="text-sm font-normal text-slate-500">#<?php echo e($pesanan->invoice); ?></span>
                </h1>
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                    <?php echo e($pesanan->created_at->format('d M Y, H:i')); ?>

                </p>
            </div>
        </div>
        
        <div>
            <?php
                $bc = [
                    'menunggu' => 'bg-blue-500/15 text-blue-400 border-blue-500/20',
                    'dikonfirmasi' => 'bg-amber-500/15 text-amber-400 border-amber-500/20',
                    'dikemas' => 'bg-purple-500/15 text-purple-400 border-purple-500/20',
                    'dikirim' => 'bg-cyan-500/15 text-cyan-400 border-cyan-500/20',
                    'diperjalanan' => 'bg-orange-500/15 text-orange-400 border-orange-500/20',
                    'selesai' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20',
                    'dibatalkan' => 'bg-red-500/15 text-red-400 border-red-500/20'
                ];
                $bl = [
                    'menunggu' => 'Menunggu',
                    'dikonfirmasi' => 'Dikonfirmasi',
                    'dikemas' => 'Dikemas',
                    'dikirim' => 'Dikirim',
                    'diperjalanan' => 'Dalam Perjalanan',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan'
                ];
            ?>
            <span class="text-xs font-bold px-3.5 py-1.5 rounded-full border <?php echo e($bc[$pesanan->status] ?? 'bg-slate-500/15 text-slate-400'); ?> uppercase tracking-wider">
                <?php echo e($bl[$pesanan->status] ?? strtoupper($pesanan->status)); ?>

            </span>
        </div>
    </div>

    <!-- Stepper Status Alur Pengiriman -->
    <?php if($pesanan->status !== 'dibatalkan'): ?>
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 shadow-xl">
        <h3 class="text-sm font-semibold text-white mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-indigo-400 text-[18px]">alt_route</span>
            Status Alur Pengiriman
        </h3>
        
        <?php
            $statuses = ['menunggu', 'dikonfirmasi', 'dikemas', 'dikirim', 'diperjalanan', 'selesai'];
            $currentIdx = array_search($pesanan->status, $statuses);
            $labels = [
                'menunggu' => 'Menunggu',
                'dikonfirmasi' => 'Dikonfirmasi',
                'dikemas' => 'Dikemas',
                'dikirim' => 'Dikirim',
                'diperjalanan' => 'Di Perjalanan',
                'selesai' => 'Selesai'
            ];
            $icons = [
                'menunggu' => 'schedule',
                'dikonfirmasi' => 'check_circle',
                'dikemas' => 'inventory_2',
                'dikirim' => 'local_shipping',
                'diperjalanan' => 'directions_bike',
                'selesai' => 'verified'
            ];
        ?>
        
        <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-6 md:gap-2">
            <!-- Connecting Line -->
            <div class="hidden md:block absolute left-8 right-8 top-5 h-0.5 bg-outline-variant/10 -z-10">
                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-500" style="width: <?php echo e($currentIdx * 20); ?>%"></div>
            </div>
            
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isCompleted = $idx <= $currentIdx;
                    $isCurrent = $idx === $currentIdx;
                ?>
                <div class="flex md:flex-col items-center gap-3.5 md:gap-2.5 flex-1 w-full md:text-center">
                    <!-- Circle -->
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border transition-all duration-300 z-10
                        <?php if($isCurrent): ?>
                            bg-indigo-600 border-indigo-500 text-white shadow-lg shadow-indigo-500/20 scale-110
                        <?php elseif($isCompleted): ?>
                            bg-indigo-500/10 border-indigo-500 text-indigo-400
                        <?php else: ?>
                            bg-[#121220] border-outline-variant/30 text-slate-600
                        <?php endif; ?>">
                        <span class="material-symbols-outlined text-[18px]"><?php echo e($icons[$st]); ?></span>
                    </div>
                    <!-- Label -->
                    <div class="flex flex-col md:items-center">
                        <span class="text-xs font-semibold <?php echo e($isCompleted ? 'text-white' : 'text-slate-500'); ?>"><?php echo e($labels[$st]); ?></span>
                        <?php if($isCurrent): ?>
                            <span class="text-[10px] text-indigo-400 font-medium mt-0.5">Sedang Diproses</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Order Items Table (Left Column) -->
        <div class="lg:col-span-2 bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-400 text-[20px]">shopping_bag</span>
                    <h3 class="text-sm font-semibold text-white">Daftar Produk</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#24243a] border-b border-outline-variant/10">
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-24">Gambar</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Detail Produk</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right w-32">Harga Satuan</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center w-24">Jumlah</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right w-36">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $pesanan->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-12 h-12 rounded-xl bg-[#121220] border border-outline-variant/20 flex items-center justify-center overflow-hidden">
                                        <img src="<?php echo e($item->produk->thumbnail_url ?? asset('images/default-product.png')); ?>" alt="<?php echo e($item->produk->name ?? 'Produk'); ?>" class="w-full h-full object-cover"/>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-white font-semibold text-[13px] block leading-tight"><?php echo e($item->produk->name ?? 'Produk Dihapus'); ?></span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <?php if($item->size): ?>
                                        <span class="text-[10px] bg-slate-500/10 text-slate-400 px-2 py-0.5 rounded-full border border-outline-variant/10">Size: <?php echo e($item->size); ?></span>
                                        <?php endif; ?>
                                        <?php if($item->color && $item->color !== '-'): ?>
                                        <span class="text-[10px] bg-slate-500/10 text-slate-400 px-2 py-0.5 rounded-full border border-outline-variant/10">Warna: <?php echo e($item->color); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[13px] text-slate-300 text-right font-medium">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                <td class="px-6 py-4 text-[13px] text-slate-300 text-center font-semibold"><?php echo e($item->quantity); ?></td>
                                <td class="px-6 py-4 text-[13px] text-emerald-400 text-right font-bold">Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-[13px]">
                                    <div class="flex flex-col items-center gap-2 py-4">
                                        <span class="material-symbols-outlined text-[40px] opacity-10">inbox</span>
                                        <span>Tidak ada item produk dalam pesanan ini</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Info (Right Column) -->
        <div class="space-y-6">
            <!-- Info Pengiriman -->
            <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-outline-variant/10 flex items-center gap-2">
                    <span class="material-symbols-outlined text-cyan-400 text-[20px]">local_shipping</span>
                    <h3 class="text-sm font-semibold text-white">Info Pengiriman</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex flex-col gap-1 pb-3 border-b border-outline-variant/5">
                        <span class="text-[10px] uppercase text-slate-500 font-bold tracking-wider">Penerima</span>
                        <span class="text-[13px] text-slate-200 font-semibold"><?php echo e($pesanan->shipping_name ?? '-'); ?></span>
                    </div>
                    <div class="flex flex-col gap-1 pb-3 border-b border-outline-variant/5">
                        <span class="text-[10px] uppercase text-slate-500 font-bold tracking-wider">Telepon</span>
                        <span class="text-[13px] text-slate-200 font-semibold"><?php echo e($pesanan->shipping_phone ?? '-'); ?></span>
                    </div>
                    <div class="flex flex-col gap-1 pb-3 border-b border-outline-variant/5">
                        <span class="text-[10px] uppercase text-slate-500 font-bold tracking-wider">Alamat Lengkap</span>
                        <span class="text-[13px] text-slate-300 leading-relaxed"><?php echo e($pesanan->shipping_address ?? '-'); ?></span>
                    </div>
                    <?php if($pesanan->tracking_number): ?>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] uppercase text-slate-500 font-bold tracking-wider">Nomor Resi</span>
                        <span class="text-[13px] text-cyan-400 font-mono font-bold"><?php echo e($pesanan->tracking_number); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info Pembayaran -->
            <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-outline-variant/10 flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-400 text-[20px]">payments</span>
                    <h3 class="text-sm font-semibold text-white">Pembayaran</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant/5">
                        <span class="text-[11px] text-slate-500 font-medium">Metode</span>
                        <span class="text-[13px] text-slate-200 font-bold uppercase"><?php echo e($pesanan->payment_method ?? '-'); ?></span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant/5">
                        <span class="text-[11px] text-slate-500 font-medium">Status Pembayaran</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full border 
                            <?php if(($pesanan->payment_status ?? 'pending') == 'paid' || ($pesanan->payment_status ?? 'pending') == 'lunas'): ?> 
                                bg-emerald-500/15 text-emerald-400 border-emerald-500/20 
                            <?php elseif(($pesanan->payment_status ?? 'pending') == 'menunggu_verifikasi'): ?>
                                bg-blue-500/15 text-blue-400 border-blue-500/20
                            <?php else: ?> 
                                bg-yellow-500/15 text-yellow-400 border-yellow-500/20 
                            <?php endif; ?>">
                            <?php if(($pesanan->payment_status ?? 'pending') == 'menunggu_verifikasi'): ?>
                                Menunggu Verifikasi
                            <?php else: ?>
                                <?php echo e(ucfirst($pesanan->payment_status ?? 'Pending')); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <?php if($pesanan->unique_code): ?>
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant/5">
                        <span class="text-[11px] text-slate-500 font-medium">Kode Unik</span>
                        <span class="text-[13px] text-amber-400 font-bold">+<?php echo e($pesanan->unique_code); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($pesanan->payment_method == 'transfer' || $pesanan->payment_method == 'ewallet'): ?>
                    <div class="flex flex-col gap-2 pt-2">
                        <span class="text-[11px] text-slate-500 font-medium">Bukti Pembayaran</span>
                        <?php if($pesanan->payment_proof): ?>
                            <div class="relative rounded-xl overflow-hidden border border-outline-variant/20 group">
                                <a href="<?php echo e(Storage::url($pesanan->payment_proof)); ?>" target="_blank" class="block">
                                    <img src="<?php echo e(Storage::url($pesanan->payment_proof)); ?>" class="w-full h-auto max-h-48 object-cover group-hover:scale-105 transition-all duration-300" alt="Bukti Pembayaran">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-semibold gap-1">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span> Lihat Detail
                                    </div>
                                </a>
                            </div>
                        <?php else: ?>
                            <span class="text-[11px] text-slate-500 italic">Belum mengunggah bukti</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Grand Total Card -->
            <div class="bg-gradient-to-br from-indigo-900/40 to-purple-900/40 rounded-2xl border border-indigo-500/30 p-6 shadow-xl relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 text-indigo-500/10 select-none">
                    <span class="material-symbols-outlined text-[120px]">payments</span>
                </div>
                <p class="text-xs text-indigo-300 font-semibold uppercase tracking-wider mb-1">Total Pembayaran</p>
                <p class="text-3xl font-black text-emerald-400">Rp <?php echo e(number_format($pesanan->total, 0, ',', '.')); ?></p>
            </div>
        </div>
    </div>

    <!-- Actions Box (Proses Pesanan) -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 shadow-xl">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-1.5 px-4 py-2 bg-slate-500/10 hover:bg-slate-500/20 text-slate-400 hover:text-white border border-outline-variant/30 rounded-xl text-xs font-semibold transition-all">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    Kembali ke Dashboard
                </a>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <?php if($pesanan->status == 'menunggu'): ?>
                    <form action="<?php echo e(route('admin.pesanan.aksi.dibatalkan', $pesanan->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-1.5 px-5 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-white border border-red-500/20 rounded-xl text-xs font-bold transition-all">
                            <span class="material-symbols-outlined text-[16px]">cancel</span>
                            Batalkan Pesanan
                        </button>
                    </form>
                    
                    <?php if($pesanan->payment_status == 'menunggu_verifikasi'): ?>
                    <form action="<?php echo e(route('admin.pesanan.aksi.verifikasi_pembayaran', $pesanan->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-1.5 px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-600/10 transition-all">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            Verifikasi Pembayaran & Konfirmasi
                        </button>
                    </form>
                    <?php else: ?>
                    <form action="<?php echo e(route('admin.pesanan.aksi.konfirmasi', $pesanan->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-1.5 px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-600/10 transition-all">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            Konfirmasi Pesanan
                        </button>
                    </form>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if($pesanan->status == 'dikonfirmasi'): ?>
                    <form action="<?php echo e(route('admin.pesanan.aksi.dikemas', $pesanan->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-1.5 px-5 py-2 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-purple-600/10 transition-all">
                            <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                            Tandai Dikemas
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($pesanan->status == 'dikemas'): ?>
                    <form action="<?php echo e(route('admin.pesanan.aksi.dikirim', $pesanan->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-1.5 px-5 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-cyan-600/10 transition-all">
                            <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                            Kirim Pesanan (Tandai Dikirim)
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($pesanan->status == 'dikirim'): ?>
                    <form action="<?php echo e(route('admin.pesanan.aksi.diperjalanan', $pesanan->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-1.5 px-5 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-orange-600/10 transition-all">
                            <span class="material-symbols-outlined text-[16px]">directions_bike</span>
                            Tandai Dalam Perjalanan
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($pesanan->status == 'diperjalanan'): ?>
                    <form action="<?php echo e(route('admin.pesanan.aksi.selesai', $pesanan->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-1.5 px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-600/10 transition-all">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            Selesai (Tandai Selesai)
                        </button>
                    </form>
                <?php endif; ?>

                <?php if(in_array($pesanan->status, ['selesai', 'dibatalkan'])): ?>
                    <div class="text-slate-500 text-xs italic flex items-center gap-1.5 py-1">
                        <span class="material-symbols-outlined text-[16px]">lock</span>
                        Pesanan telah selesai/dibatalkan dan terkunci.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKM/UMKM-main/resources/views/admin/pesanan/show.blade.php ENDPATH**/ ?>