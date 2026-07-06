@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('additional-css')
<style>
@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
}
</style>
@endsection

@section('content')
<div class="max-w-[1200px] mx-auto bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden">

    <!-- Toast -->
    <div id="toast" class="fixed top-6 right-6 z-[9999] hidden">
        <div class="flex items-center gap-3 bg-[#1c1c2d] border border-emerald-500/40 rounded-xl px-5 py-4 shadow-2xl shadow-emerald-500/10">
            <span class="material-symbols-outlined text-emerald-400 text-[22px]">check_circle</span>
            <div>
                <p class="text-white text-sm font-semibold">Berhasil!</p>
                <p id="toast-msg" class="text-slate-400 text-xs mt-0.5">Produk berhasil ditambahkan</p>
            </div>
        </div>
    </div>

    <div class="p-8">

        <!-- Title -->
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-indigo-500/15 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-indigo-400 text-[20px]">add_box</span>
            </div>
            <div>
                <h2 class="text-[20px] font-semibold text-white">Form Produk Baru</h2>
                <p class="text-[12px] text-slate-500 mt-1">Isi data produk baru dengan lengkap</p>
            </div>
        </div>

        <form id="form-produk" method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Baris 1: Nama + Slug -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold" for="nama">
                        Nama Produk <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="nama" name="name" value="{{ old('name') }}" required
                        class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]"
                        placeholder="Masukkan nama produk"/>
                    @error('name')
                        <p class="text-red-400 text-[11px] flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold">Slug Preview</label>
                    <div id="slug" class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-slate-500 text-[13px] truncate">{{ old('slug', '-') }}</div>
                    <input type="hidden" name="slug" id="slug-input" value="{{ old('slug') }}"/>
                </div>
            </div>

            <!-- Baris 2: Brand + Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold" for="brand_id">
                        Merek <span class="text-red-400">*</span>
                    </label>
                    <select id="brand_id" name="brand_id" required
                        class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px] appearance-none cursor-pointer">
                        <option value="">Pilih Merek</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }} class="bg-[#121220]">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-red-400 text-[11px] flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold" for="kategori_id">
                        Kategori <span class="text-red-400">*</span>
                    </label>
                    <select id="kategori_id" name="kategori_id" required
                        class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px] appearance-none cursor-pointer">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }} class="bg-[#121220]">
                                {{ $kategori->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-400 text-[11px] flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Baris 3: Harga + Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold" for="price">
                        Harga (Rp) <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0"
                        class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]"
                        placeholder="0"/>
                    @error('price')
                        <p class="text-red-400 text-[11px] flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold" for="stock">
                        Stok <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="stock" value="{{ old('stock') }}" required min="0"
                        class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]"
                        placeholder="0"/>
                    @error('stock')
                        <p class="text-red-400 text-[11px] flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Ukuran -->
            <div class="mb-5 space-y-2">
                <div class="flex items-center justify-between">
                    <label class="text-[12px] text-slate-400 uppercase font-bold">
                        Ukuran Produk <span class="text-red-400">*</span>
                    </label>
                    <button type="button" onclick="addSize()" class="text-indigo-400 hover:text-indigo-300 text-[12px] font-semibold transition-colors flex items-center gap-1">
                        <span class="text-[16px]">+</span>
                        Tambah Ukuran
                    </button>
                </div>
                <div id="size-list" class="flex flex-wrap gap-2">
                    @foreach(old('sizes', ['']) as $size)
                        <div class="flex items-center gap-2">
                            <input type="text" name="sizes[]" value="{{ $size }}" required
                                class="bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]"
                                placeholder="Contoh: S, M, L, XL"/>
                            <button type="button" onclick="this.closest('.flex').remove()" class="text-red-400 hover:text-red-300 text-[16px] transition-colors">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                            </button>
                        </div>
                    @endforeach
                </div>
                @error('sizes')
                    <p class="text-red-400 text-[11px] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Warna -->
            <div class="mb-5 space-y-2">
                <div class="flex items-center justify-between">
                    <label class="text-[12px] text-slate-400 uppercase font-bold">
                        Warna Produk <span class="text-red-400">*</span>
                    </label>
                    <button type="button" onclick="addColor()" class="text-indigo-400 hover:text-indigo-300 text-[12px] font-semibold transition-colors flex items-center gap-1">
                        <span class="text-[16px]">+</span>
                        Tambah Warna
                    </button>
                </div>
                <div id="color-list" class="flex flex-wrap gap-2">
                    @foreach(old('colors', ['']) as $color)
                        <div class="flex items-center gap-2">
                            <input type="text" name="colors[]" value="{{ $color }}" required
                                class="bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]"
                                placeholder="Contoh: Merah, Biru"/>
                            <button type="button" onclick="this.closest('.flex').remove()" class="text-red-400 hover:text-red-300 text-[16px] transition-colors">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                            </button>
                        </div>
                    @endforeach
                </div>
                @error('colors')
                    <p class="text-red-400 text-[11px] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Gambar -->
            <div class="mb-5 space-y-2">
                <label class="block text-[12px] text-slate-400 uppercase font-bold" for="image">
                    Gambar Produk <span class="text-red-400">*</span>
                </label>
                <div class="relative flex items-center bg-[#121220] border border-outline-variant/30 rounded-lg overflow-hidden">
                    <label class="cursor-pointer bg-[#2a2a40] text-slate-300 px-5 py-3 text-[12px] font-medium hover:bg-[#333350] transition-colors border-r border-outline-variant/30 shrink-0" for="image">
                        Telusuri...
                    </label>
                    <span class="px-4 text-slate-500 text-[12px] truncate flex-1" id="gambar-name-display">Tidak ada berkas dipilih</span>
                    <input accept="image/*" class="hidden" id="image" name="image" required type="file" onchange="previewImg(this)"/>
                </div>
                <div id="gambar-preview" class="hidden mt-3">
                    <div class="bg-[#121220] rounded-xl p-2 border border-outline-variant/20 inline-block w-fit">
                        <img id="gambar-preview-img" class="max-h-[180px] rounded-lg object-contain" src="" alt="Preview"/>
                    </div>
                </div>
                @error('image')
                    <p class="text-red-400 text-[11px] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-5 space-y-2">
                <label class="block text-[12px] text-slate-400 uppercase font-bold" for="description">
                    Deskripsi
                </label>
                <textarea name="description" rows="4"
                    class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px] resize-none"
                    placeholder="Tulis deskripsi produk...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-[11px] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex gap-3 pt-6 border-t border-outline-variant/10">
                <a href="{{ route('admin.produk') }}" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-[#2a2a40] hover:bg-[#333350] text-slate-300 text-[13px] font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </a>
                <button type="submit" id="btn-submit"
                    class="flex-1 flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-[13px] font-semibold transition-colors shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[18px]" id="btn-icon">save</span>
                    <span id="btn-text">Simpan Produk</span>
                    <svg id="btn-spinner" class="animate-spin h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
(() => {
// Slug otomatis
document.getElementById('nama').addEventListener('input', function() {
    let val = this.value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    document.getElementById('slug').textContent = val || '-';
    document.getElementById('slug-input').value = val;
});

// Tambah ukuran
function addSize() {
    const list = document.getElementById('size-list');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2';
    div.innerHTML = '<input type="text" name="sizes[]" value="" required class="bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]" placeholder="Contoh: S, M, L, XL"/><button type="button" onclick="this.closest(\'.flex\').remove()" class="text-red-400 hover:text-red-300 text-[16px] transition-colors"><span class="material-symbols-outlined text-[16px]">close</span></button>';
    list.appendChild(div);
    div.querySelector('input').focus();
}

// Tambah warna
function addColor() {
    const list = document.getElementById('color-list');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2';
    div.innerHTML = '<input type="text" name="colors[]" value="" required class="bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]" placeholder="Contoh: Merah, Biru"/><button type="button" onclick="this.closest(\'.flex\').remove()" class="text-red-400 hover:text-red-300 text-[16px] transition-colors"><span class="material-symbols-outlined text-[16px]">close</span></button>';
    list.appendChild(div);
    div.querySelector('input').focus();
}

// Preview gambar
function previewImg(input) {
    const display = document.getElementById('gambar-name-display');
    const preview = document.getElementById('gambar-preview');
    const previewImg = document.getElementById('gambar-preview-img');
    if (input.files.length > 0) {
        display.textContent = input.files[0].name;
        display.classList.remove('text-slate-500');
        display.classList.add('text-slate-200');
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        display.textContent = 'Tidak ada berkas dipilih';
        display.classList.add('text-slate-500');
        display.classList.remove('text-slate-200');
        preview.classList.add('hidden');
    }
}

// Submit via AJAX
document.getElementById('form-produk').addEventListener('submit', function(e) {
    e.preventDefault();

    const btn = document.getElementById('btn-submit');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');
    const btnSpinner = document.getElementById('btn-spinner');

    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-not-allowed');
    btnText.textContent = 'Menyimpan...';
    btnIcon.classList.add('hidden');
    btnSpinner.classList.remove('hidden');

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(res => {
        if (!res.ok) return res.json().then(err => { throw err; });
        return res.json();
    })
    .then(data => {
        const toast = document.getElementById('toast');
        const toastMsg = document.getElementById('toast-msg');
        if (data.message) toastMsg.textContent = data.message;
        toast.classList.remove('hidden');
        toast.style.animation = 'slideIn 0.3s ease-out';

        setTimeout(() => {
            window.location.href = data.redirect || '{{ route("admin.produk") }}';
        }, 1500);
    })
    .catch(err => {
        document.querySelectorAll('.field-error').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500\\/50').forEach(el => el.classList.remove('border-red-500/50'));

        if (err.errors) {
            Object.entries(err.errors).forEach(([field, messages]) => {
                const input = document.querySelector('[name="' + field + '"]');
                if (input) {
                    const p = document.createElement('p');
                    p.className = 'field-error text-red-400 text-[11px] flex items-center gap-1 mt-1';
                    p.innerHTML = '<span class="material-symbols-outlined text-[13px]">error</span> ' + messages[0];
                    input.closest('.space-y-2').appendChild(p);
                    input.classList.add('border-red-500/50');
                }
            });

            const firstError = document.querySelector('.field-error');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        btn.disabled = false;
        btn.classList.remove('opacity-70', 'cursor-not-allowed');
        btnText.textContent = 'Simpan Produk';
        btnIcon.classList.remove('hidden');
        btnSpinner.classList.add('hidden');
    });
});

// Expose to window for inline HTML handlers
window.addSize = addSize;
window.addColor = addColor;
window.previewImg = previewImg;
})();
</script>
@endsection