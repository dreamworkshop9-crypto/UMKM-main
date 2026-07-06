<?php $__env->startSection('title', 'Kelola Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1200px] mx-auto space-y-6">
    
    <!-- Header Banner -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-xl">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400">
                <span class="material-symbols-outlined text-[24px]">local_shipping</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">Kelola Estimasi & Biaya Pengiriman</h1>
                <p class="text-xs text-slate-500 mt-1">Atur tarif ongkos kirim dan estimasi waktu pengiriman berdasarkan provinsi dan kurir.</p>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 p-5 shadow-xl flex flex-col sm:flex-row items-center gap-4 justify-between">
        <div class="relative w-full sm:w-80">
            <input type="text" id="shippingSearch" placeholder="Cari provinsi..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-900/60 border border-outline-variant/30 rounded-xl text-white placeholder:text-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-[18px]">search</span>
        </div>
        
        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
            <span class="text-xs text-slate-400 font-medium hidden md:inline">Filter Kurir:</span>
            <select id="shippingFilterCourier" class="px-4 py-2.5 text-sm bg-slate-900/60 border border-outline-variant/30 rounded-xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none min-w-[140px]">
                <option value="all">Semua Kurir</option>
                <option value="jne">JNE</option>
                <option value="jnt">J&T</option>
                <option value="sicepat">SiCepat</option>
            </select>
        </div>
    </div>

    <!-- Shipping Rates Table Card -->
    <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#24243a] border-b border-outline-variant/10">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Provinsi</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-32">Kurir</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right w-44">Biaya Ongkir</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-48">Estimasi Pengiriman</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody id="shippingTableBody" class="divide-y divide-outline-variant/5">
                    <!-- Rows rendered dynamically by JS -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-outline-variant/10 flex items-center justify-between flex-col sm:flex-row gap-3">
            <p class="text-xs text-slate-500">
                Menampilkan <span id="showingStart" class="text-slate-300 font-semibold">0</span> - <span id="showingEnd" class="text-slate-300 font-semibold">0</span> dari <span id="totalItems" class="text-slate-300 font-semibold">0</span> lokasi
            </p>
            <div id="shippingPagination" class="flex items-center gap-1.5">
                <!-- Pagination buttons rendered dynamically by JS -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editShippingModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[70] transition-all duration-300 opacity-0 pointer-events-none">
    <div class="bg-[#1c1c2d] border border-outline-variant/30 rounded-2xl p-6 w-full max-w-md shadow-2xl transform scale-95 transition-all duration-300 space-y-5">
        <div class="flex items-center justify-between border-b border-outline-variant/10 pb-3">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-400 text-[20px]">edit_road</span>
                Edit Biaya & Estimasi
            </h3>
            <button onclick="closeEditModal()" class="w-8 h-8 rounded-lg hover:bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <form id="editShippingForm" class="space-y-4" onsubmit="submitEditForm(event)">
            <input type="hidden" id="editRateId">
            
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Provinsi</label>
                <input type="text" id="editProvince" disabled class="w-full px-4 py-2.5 text-sm bg-slate-900/40 border border-outline-variant/20 rounded-xl text-slate-400 outline-none cursor-not-allowed">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Kurir</label>
                <input type="text" id="editCourier" disabled class="w-full px-4 py-2.5 text-sm bg-slate-900/40 border border-outline-variant/20 rounded-xl text-slate-400 outline-none cursor-not-allowed uppercase font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Biaya Ongkos Kirim (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">Rp</span>
                    <input type="number" id="editCost" required min="0" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-900 border border-outline-variant/30 rounded-xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Estimasi Waktu Pengiriman</label>
                <div class="relative">
                    <input type="text" id="editEstimation" required placeholder="Contoh: 2-3 Hari, 4-6 Hari" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-900 border border-outline-variant/30 rounded-xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">schedule</span>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2 justify-end">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold rounded-xl transition-colors">Batal</button>
                <button type="submit" id="saveBtn" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Seeded data from database passed through Blade
    const allRates = <?php echo json_encode($rates, 15, 512) ?>;

    let filteredRates = [...allRates];
    let currentPage = 1;
    const itemsPerPage = 12;

    const courierBadges = {
        'jne': { bg: 'bg-blue-500/10 text-blue-400 border-blue-500/20', label: 'JNE' },
        'jnt': { bg: 'bg-red-500/10 text-red-400 border-red-500/20', label: 'J&T' },
        'sicepat': { bg: 'bg-orange-500/10 text-orange-400 border-orange-500/20', label: 'SiCepat' }
    };

    // Format money helper
    function formatRp(val) {
        return 'Rp ' + Number(val || 0).toLocaleString('id-ID');
    }

    // Dynamic Filter & Render
    function filterAndRender() {
        const query = document.getElementById('shippingSearch').value.toLowerCase().trim();
        const courier = document.getElementById('shippingFilterCourier').value;

        filteredRates = allRates.filter(item => {
            const matchesQuery = item.province_name.toLowerCase().includes(query);
            const matchesCourier = courier === 'all' || item.courier === courier;
            return matchesQuery && matchesCourier;
        });

        currentPage = 1;
        renderTable();
    }

    function renderTable() {
        const tbody = document.getElementById('shippingTableBody');
        tbody.innerHTML = '';

        if (filteredRates.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-[40px] opacity-10">inbox</span>
                            <span class="text-sm">Tidak ada data tarif pengiriman ditemukan</span>
                        </div>
                    </td>
                </tr>
            `;
            document.getElementById('showingStart').textContent = '0';
            document.getElementById('showingEnd').textContent = '0';
            document.getElementById('totalItems').textContent = '0';
            document.getElementById('shippingPagination').innerHTML = '';
            return;
        }

        const totalItems = filteredRates.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        
        // Boundaries
        const start = (currentPage - 1) * itemsPerPage;
        const end = Math.min(start + itemsPerPage, totalItems);
        const pageItems = filteredRates.slice(start, end);

        pageItems.forEach((item, index) => {
            const cInfo = courierBadges[item.courier] || { bg: 'bg-slate-500/10 text-slate-400 border-slate-500/20', label: item.courier.toUpperCase() };
            const row = document.createElement('tr');
            row.className = 'border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors';
            row.innerHTML = `
                <td class="px-6 py-4 text-sm text-slate-500 font-mono">${start + index + 1}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-slate-500 text-[18px]">pin_drop</span>
                        <span class="text-white font-semibold text-[13px]">${item.province_name}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full border ${cInfo.bg}">
                        ${cInfo.label}
                    </span>
                </td>
                <td class="px-6 py-4 text-[13px] text-emerald-400 text-right font-bold font-mono">${formatRp(item.cost)}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2 text-xs text-slate-300">
                        <span class="material-symbols-outlined text-slate-500 text-[16px]">schedule</span>
                        <span>${item.estimation || '2-3 Hari'}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <button onclick="openEditModal(${item.id})" class="w-8 h-8 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 flex items-center justify-center text-indigo-400 hover:text-indigo-300 transition-colors" title="Edit Tarif & Estimasi">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });

        // Update counts
        document.getElementById('showingStart').textContent = start + 1;
        document.getElementById('showingEnd').textContent = end;
        document.getElementById('totalItems').textContent = totalItems;

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const pagContainer = document.getElementById('shippingPagination');
        pagContainer.innerHTML = '';

        if (totalPages <= 1) return;

        // Prev Button
        const prevBtn = document.createElement('button');
        prevBtn.className = `w-8 h-8 rounded-lg border border-outline-variant/30 bg-slate-800 flex items-center justify-center text-slate-400 transition-all ${currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-700 hover:text-white'}`;
        prevBtn.innerHTML = '<span class="material-symbols-outlined text-[16px]">chevron_left</span>';
        prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderTable(); } };
        pagContainer.appendChild(prevBtn);

        // Page Numbers (limited to 5 for nice clean display)
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }

        for (let p = startPage; p <= endPage; p++) {
            const btn = document.createElement('button');
            btn.className = `w-8 h-8 rounded-lg text-xs font-bold transition-all flex items-center justify-center ${p === currentPage ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'border border-outline-variant/30 bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-white'}`;
            btn.textContent = p;
            btn.onclick = () => { currentPage = p; renderTable(); };
            pagContainer.appendChild(btn);
        }

        // Next Button
        const nextBtn = document.createElement('button');
        nextBtn.className = `w-8 h-8 rounded-lg border border-outline-variant/30 bg-slate-800 flex items-center justify-center text-slate-400 transition-all ${currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-700 hover:text-white'}`;
        nextBtn.innerHTML = '<span class="material-symbols-outlined text-[16px]">chevron_right</span>';
        nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; renderTable(); } };
        pagContainer.appendChild(nextBtn);
    }

    // Modal Control
    function openEditModal(id) {
        const item = allRates.find(x => x.id === id);
        if (!item) return;

        document.getElementById('editRateId').value = item.id;
        document.getElementById('editProvince').value = item.province_name;
        document.getElementById('editCourier').value = item.courier;
        document.getElementById('editCost').value = item.cost;
        document.getElementById('editEstimation').value = item.estimation || '2-3 Hari';

        const modal = document.getElementById('editShippingModal');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.firstElementChild.classList.remove('scale-95');
        modal.firstElementChild.classList.add('scale-100');
    }

    function closeEditModal() {
        const modal = document.getElementById('editShippingModal');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.firstElementChild.classList.remove('scale-100');
        modal.firstElementChild.classList.add('scale-95');
    }

    // Custom Styled Toast Notification
    function showToast(message, type = 'success') {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'fixed top-6 right-6 z-[80] space-y-3 pointer-events-none';
            document.body.appendChild(container);
        }

        const icons = {
            success: 'check_circle text-emerald-400',
            error: 'cancel text-red-400'
        };

        const toast = document.createElement('div');
        toast.className = 'pointer-events-auto flex items-center gap-3 px-5 py-3.5 bg-[#1c1c2d] border border-outline-variant/30 rounded-xl shadow-2xl min-w-[300px] transform translate-x-12 opacity-0 transition-all duration-300';
        toast.innerHTML = `
            <span class="material-symbols-outlined ${icons[type]}">${type === 'success' ? 'check_circle' : 'cancel'}</span>
            <span class="text-sm font-semibold text-white flex-1">${message}</span>
        `;
        container.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('translate-x-12', 'opacity-0');
        }, 10);

        // Slide out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-12', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Submit Edit Form
    async function submitEditForm(e) {
        e.preventDefault();
        
        const id = document.getElementById('editRateId').value;
        const cost = document.getElementById('editCost').value;
        const estimation = document.getElementById('editEstimation').value;

        const saveBtn = document.getElementById('saveBtn');
        const originalBtnHTML = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] animate-spin">sync</span> Menyimpan...';

        try {
            const response = await fetch(`/admin/shipping/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ cost, estimation })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Gagal menyimpan perubahan');
            }

            // Update local memory data
            const localItem = allRates.find(x => x.id == id);
            if (localItem) {
                localItem.cost = Number(cost);
                localItem.estimation = estimation;
            }

            showToast(data.message || 'Estimasi dan ongkir berhasil diperbarui!');
            closeEditModal();
            renderTable();

        } catch (error) {
            showToast(error.message || 'Terjadi kesalahan sistem', 'error');
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalBtnHTML;
        }
    }

    // Event listeners
    document.getElementById('shippingSearch').addEventListener('input', filterAndRender);
    document.getElementById('shippingFilterCourier').addEventListener('change', filterAndRender);

    // Initial render
    renderTable();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKM/UMKM-main/resources/views/admin/shipping/index.blade.php ENDPATH**/ ?>