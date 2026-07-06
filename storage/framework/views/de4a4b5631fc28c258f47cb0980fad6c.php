<?php $__env->startSection('title', 'Metode Pembayaran - SALZA'); ?>
<?php $__env->startSection('page-title', 'Metode Pembayaran'); ?>

<?php $__env->startSection('additional-css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .toggle-checkbox:checked {
        right: 0;
        border-color: #6366f1;
    }
    .toggle-checkbox:checked + .toggle-label {
        background-color: #6366f1;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header Card -->
    <div class="bg-[#1c1c2d] p-6 rounded-xl border border-outline-variant/20 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                <span class="material-symbols-outlined text-[30px]">payments</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">Metode Pembayaran</h2>
                <p class="text-sm text-slate-400">Kelola rekening bank, deskripsi COD, dan upload kode QRIS untuk transaksi pelanggan.</p>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3 text-emerald-400 text-sm">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span><?php echo e(session('success')); ?></span>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.payment.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        <!-- 1. TRANSFER BANK CARD -->
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-indigo-400">account_balance</span>
                    <div>
                        <h3 class="text-base font-bold text-white">1. Transfer Bank Manual</h3>
                        <p class="text-xs text-slate-500">Mendukung transfer antar bank lokal secara manual.</p>
                    </div>
                </div>
                <!-- Toggle Switch -->
                <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" name="transfer_active" id="transfer_active" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-slate-600 border-4 border-slate-800 appearance-none cursor-pointer focus:outline-none transition-all duration-300" <?php echo e($methods->get('transfer')?->is_active ? 'checked' : ''); ?>/>
                    <label for="transfer_active" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-800 border border-slate-700 cursor-pointer"></label>
                </div>
            </div>
            
            <div class="p-6 space-y-4">
                <label class="block text-sm font-semibold text-slate-300">Daftar Rekening Bank:</label>
                
                <div id="bank-accounts-container" class="space-y-3">
                    <?php
                        $banks = $methods->get('transfer')?->details ?? [];
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bank-row flex flex-col md:flex-row gap-3 items-center bg-slate-900/50 p-4 rounded-xl border border-slate-800/60">
                        <div class="w-full md:w-1/4">
                            <label class="block text-xs text-slate-500 mb-1">Nama Bank</label>
                            <input type="text" name="bank_name[]" value="<?php echo e($bank['bank'] ?? ''); ?>" placeholder="Contoh: BCA" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="block text-xs text-slate-500 mb-1">Nomor Rekening</label>
                            <input type="text" name="bank_account[]" value="<?php echo e($bank['account_number'] ?? ''); ?>" placeholder="Contoh: 123-456-7890" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="block text-xs text-slate-500 mb-1">Nama Pemilik Rekening</label>
                            <input type="text" name="bank_holder[]" value="<?php echo e($bank['account_name'] ?? ''); ?>" placeholder="Contoh: ShoesMarket" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="pt-5">
                            <button type="button" onclick="removeBankRow(this)" class="w-9 h-9 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white rounded-lg flex items-center justify-center transition-all" title="Hapus Rekening">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bank-row flex flex-col md:flex-row gap-3 items-center bg-slate-900/50 p-4 rounded-xl border border-slate-800/60">
                        <div class="w-full md:w-1/4">
                            <label class="block text-xs text-slate-500 mb-1">Nama Bank</label>
                            <input type="text" name="bank_name[]" placeholder="Contoh: BCA" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="block text-xs text-slate-500 mb-1">Nomor Rekening</label>
                            <input type="text" name="bank_account[]" placeholder="Contoh: 123-456-7890" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="block text-xs text-slate-500 mb-1">Nama Pemilik Rekening</label>
                            <input type="text" name="bank_holder[]" placeholder="Contoh: ShoesMarket" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="pt-5">
                            <button type="button" onclick="removeBankRow(this)" class="w-9 h-9 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white rounded-lg flex items-center justify-center transition-all" title="Hapus Rekening">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <button type="button" onclick="addBankRow()" class="mt-2 px-4 py-2 bg-indigo-500/10 hover:bg-indigo-500 text-indigo-400 hover:text-white rounded-lg text-xs font-semibold flex items-center gap-2 transition-all">
                    <i class="fa-solid fa-plus"></i> Tambah Rekening Bank
                </button>
            </div>
        </div>

        <!-- 2. COD (BAYAR DI TEMPAT) CARD -->
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-indigo-400">hand_holding_dollar</span>
                    <div>
                        <h3 class="text-base font-bold text-white">2. COD (Bayar di Tempat)</h3>
                        <p class="text-xs text-slate-500">Pelanggan membayar secara tunai langsung ke kurir saat pengiriman.</p>
                    </div>
                </div>
                <!-- Toggle Switch -->
                <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" name="cod_active" id="cod_active" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-slate-600 border-4 border-slate-800 appearance-none cursor-pointer focus:outline-none transition-all duration-300" <?php echo e($methods->get('cod')?->is_active ? 'checked' : ''); ?>/>
                    <label for="cod_active" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-800 border border-slate-700 cursor-pointer"></label>
                </div>
            </div>
            
            <div class="p-6">
                <label class="block text-sm font-semibold text-slate-300 mb-2">Petunjuk Pembayaran COD:</label>
                <textarea name="cod_description" rows="3" placeholder="Masukkan instruksi COD bagi pelanggan..." class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all resize-none"><?php echo e($methods->get('cod')?->details['description'] ?? ''); ?></textarea>
            </div>
        </div>

        <!-- 3. E-WALLET / QRIS CARD -->
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-indigo-400">qr_code_2</span>
                    <div>
                        <h3 class="text-base font-bold text-white">3. E-Wallet (QRIS)</h3>
                        <p class="text-xs text-slate-500">Mendukung pembayaran digital otomatis/manual via Scan QRIS.</p>
                    </div>
                </div>
                <!-- Toggle Switch -->
                <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" name="ewallet_active" id="ewallet_active" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-slate-600 border-4 border-slate-800 appearance-none cursor-pointer focus:outline-none transition-all duration-300" <?php echo e($methods->get('ewallet')?->is_active ? 'checked' : ''); ?>/>
                    <label for="ewallet_active" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-800 border border-slate-700 cursor-pointer"></label>
                </div>
            </div>
            
            <div class="p-6 space-y-4">
                <?php
                    $ewallet = $methods->get('ewallet');
                    $ewalletDetails = $ewallet?->details ?? [];
                ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Text inputs -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1.5">Nomor Telepon Akun (Backup Transfer)</label>
                            <input type="text" name="ewallet_phone" value="<?php echo e($ewalletDetails['phone'] ?? ''); ?>" placeholder="Contoh: 0812-3456-7890" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1.5">Nama Pemilik Akun</label>
                            <input type="text" name="ewallet_holder" value="<?php echo e($ewalletDetails['account_name'] ?? ''); ?>" placeholder="Contoh: ShoesMarket" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1.5">Unggah QR Code QRIS Baru</label>
                            <input type="file" name="ewallet_qris" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 transition-all">
                            <p class="text-[10px] text-slate-500 mt-1">Mendukung format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                        </div>
                    </div>
                    
                    <!-- QRIS Preview -->
                    <div class="flex flex-col items-center justify-center border border-slate-800 bg-slate-900/40 rounded-xl p-4">
                        <p class="text-xs text-slate-500 mb-2 font-semibold">QRIS QR Code Aktif:</p>
                        <div class="w-36 h-36 bg-white p-2 rounded-lg flex items-center justify-center shadow-lg">
                            <img src="<?php echo e($ewalletDetails['qris_image'] ?? '/images/qris_mockup.png'); ?>" alt="QRIS QR Code" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SAVE BUTTON -->
        <div class="flex justify-end pt-2">
            <button type="submit" class="px-6 py-3.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk text-sm"></i> Simpan Semua Perubahan
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional-js'); ?>
<script>
    function addBankRow() {
        const container = document.getElementById('bank-accounts-container');
        const row = document.createElement('div');
        row.className = 'bank-row flex flex-col md:flex-row gap-3 items-center bg-slate-900/50 p-4 rounded-xl border border-slate-800/60';
        row.innerHTML = `
            <div class="w-full md:w-1/4">
                <label class="block text-xs text-slate-500 mb-1">Nama Bank</label>
                <input type="text" name="bank_name[]" placeholder="Contoh: BCA" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-xs text-slate-500 mb-1">Nomor Rekening</label>
                <input type="text" name="bank_account[]" placeholder="Contoh: 123-456-7890" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-xs text-slate-500 mb-1">Nama Pemilik Rekening</label>
                <input type="text" name="bank_holder[]" placeholder="Contoh: ShoesMarket" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
            </div>
            <div class="pt-5">
                <button type="button" onclick="removeBankRow(this)" class="w-9 h-9 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white rounded-lg flex items-center justify-center transition-all" title="Hapus Rekening">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    }

    function removeBankRow(button) {
        const row = button.closest('.bank-row');
        const container = document.getElementById('bank-accounts-container');
        
        // Keep at least one bank row
        if (container.getElementsByClassName('bank-row').length > 1) {
            row.remove();
        } else {
            // Clear the inputs instead of removing
            row.querySelectorAll('input').forEach(input => input.value = '');
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKM/UMKM-main/resources/views/admin/payment/index.blade.php ENDPATH**/ ?>