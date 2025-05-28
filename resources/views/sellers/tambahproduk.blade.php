@extends('layouts.seller')
@section('title', 'Tambah Produk - Scentscape')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')
<form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="max-w-3xl mx-auto p-6 bg-[#F6F1EB] rounded-2xl shadow-lg mt-6">
        <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2 text-[#3E3A39]">
            🎁 Tambah Produk
        </h2>

        <!-- Nama Produk -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Nama Produk</label>
            <input type="text" name="nama_produk" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Masukkan nama produk" />
        </div>

        <!-- Deskripsi Produk -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Deskripsi Produk</label>
            <textarea rows="5" name="deskripsi" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Tulis deskripsi lengkap, termasuk karakter aroma (top, middle, base notes), kondisi pemakaian, dan lainnya..."></textarea>
            <p class="text-xs text-[#3E3A39] mt-1">Deskripsi akan ditampilkan sesuai format (paragraf, numbering, dll) yang diinput penjual.</p>
        </div>

        <!-- Label Kategori Gender -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Label Gender</label>
            <select name="label_kategori" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
                <option value="" disabled selected>Pilih Label Kategori</option>
                @foreach($labelKategoriList as $label)
                <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tipe Parfum -->
        <div class="mb-4">
            <label for="tipe_parfum" class="block text-sm font-medium text-[#3E3A39] mb-1">
                Tipe Produk
            </label>
            <select id="tipe_parfum" name="tipe_parfum"
                class="w-full border border-[#9BAF9A] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
                <option value="" disabled selected>Pilih Tipe Parfum</option>
                <option value="Eau De Parfum (EDP)">Eau De Parfum (EDP)</option>
                <option value="Eau De Toilette (EDT)">Eau De Toilette (EDT)</option>
                <option value="Body Mist">Body Mist</option>
                <option value="Cologne">Cologne</option>
                <option value="Perfume Oil">Perfume Oil</option>
                <option value="Solid Perfume">Solid Perfume</option>
            </select>
        </div>

        <!-- Volume -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Volume</label>
            <input type="text" name="volume" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="contoh: 50ml" />
        </div>

        <!-- Harga -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Harga</label>
            <input type="number" name="harga" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Masukkan harga produk" />
        </div>

        <!-- Kategori Aroma -->
        <div x-data="{ selected: [], showAromaForm: false, newAroma: '' }"
            x-init="
            window.selected = selected;
            window.getAromaForm = () => $el;
            window.closeAromaForm = () => { showAromaForm = false; newAroma = ''; };"
            x-ref="modalAroma"
            class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-2">Kategori</label>
            <div class="flex flex-wrap gap-2">
                <!-- Tombol untuk tambah aroma -->
                <button type="button" @click="showAromaForm = true"
                    class="w-8 h-8 rounded-full flex items-center justify-center bg-[#9BAF9A] text-white text-lg hover:bg-[#8DA089] shadow">
                    +
                </button>

                <!-- Semua kategori -->
                @foreach ($categories as $category)
                <button type="button"
                    @click="selected.includes('{{ $category }}') ? selected = selected.filter(i => i !== '{{ $category }}') : selected.push('{{ $category }}')"
                    :class="selected.includes('{{ $category }}') ? 'bg-[#9BAF9A] text-white' : 'bg-[#F6F1EB] text-[#3E3A39]'"
                    class="border border-[#9BAF9A] px-3 py-1 rounded-full text-sm">
                    {{ $category }}
                </button>
                @endforeach
            </div>

            <!-- Hidden inputs -->
            <template x-for="item in selected" :key="item">
                <input type="hidden" name="categories[]" :value="item">
            </template>

            <!-- Modal pop-up untuk tambah aroma -->
            <div x-show="showAromaForm" @click.outside="showAromaForm = false"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
                <div class="bg-white rounded-xl shadow-lg p-6 w-80">
                    <h3 class="text-lg font-semibold text-[#3E3A39] mb-3">Tambah Aroma</h3>
                    <input type="text" id="inputAromaBaru" x-model="newAroma" placeholder="Contoh: Citrus Fresh"
                        class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 mb-4 focus:ring-[#9BAF9A] focus:outline-none">
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="BatalSimpanAroma"
                            class="px-4 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>

                        <button type="button" id="simpanAroma"
                            class="px-4 py-1 rounded bg-[#9BAF9A] text-white hover:bg-[#8DA089]">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Stok</label>
            <input type="number" name="stok" min="0" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Masukkan jumlah stok tersedia" />
        </div>

        <!-- Foto Produk -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#3E3A39] mb-1">Foto Produk</label>
            <input type="file" name="gambar[]" multiple accept="image/*" multiple class="block w-full text-sm text-gray-500 file:py-2 file:px-4
        file:rounded-lg file:border-0
        file:text-sm file:font-semibold
        file:bg-[#D6C6B8] file:text-[#3E3A39]
        hover:file:bg-[#BFA6A0]
        file:w-auto file:ml-2" />
            <p class="text-xs text-[#3E3A39] mt-1">Upload 1 atau lebih foto produk (maks 5 MB per file)</p>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="bg-[#9BAF9A] hover:bg-[#8DA089] text-white font-semibold px-6 py-2 rounded-lg shadow transition-all">
            Tambah Produk
        </button>
    </div>
</form>
@endsection