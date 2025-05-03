@extends('layouts.seller')
@section('title', 'Tambah Produk - Scentscape')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-[#F6F1EB] rounded-2xl shadow-lg mt-6">
    <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2 text-[#3E3A39]">
        🎁 Tambah Produk
    </h2>

    <!-- Nama Produk -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Nama Produk</label>
        <input type="text" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Masukkan nama produk" />
    </div>

    <!-- Deskripsi Produk -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Deskripsi Produk</label>
        <textarea rows="5" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Tulis deskripsi lengkap, termasuk karakter aroma (top, middle, base notes), kondisi pemakaian, dan lainnya..."></textarea>
        <p class="text-xs text-[#3E3A39] mt-1">Deskripsi akan ditampilkan sesuai format (paragraf, numbering, dll) yang diinput penjual.</p>
    </div>

    <!-- Label Gender -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Label Gender</label>
        <select class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
            <option>Unisex</option>
            <option>Pria</option>
            <option>Wanita</option>
        </select>
    </div>

    <!-- Tipe Produk -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Tipe Produk</label>
        <select class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]">
            <option>Eau De Parfum (EDP)</option>
            <option>Eau De Toilette (EDT)</option>
            <option>Body Mist</option>
        </select>
    </div>

    <!-- Volume -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Volume</label>
        <input type="text" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="contoh: 50ml" />
    </div>

    <!-- Harga -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Harga</label>
        <input type="number" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Masukkan harga produk" />
    </div>

    <!-- Kategori -->
    <div x-data="{ selected: [] }" class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-2">Kategori</label>
        <div class="flex flex-wrap gap-2">
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
    </div>

    <!-- Stok -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Stok</label>
        <input type="number" min="0" class="w-full border border-[#D6C6B8] rounded-lg px-4 py-2 bg-white text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]" placeholder="Masukkan jumlah stok tersedia" />
    </div>

    <!-- Foto Produk -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-[#3E3A39] mb-1">Foto Produk</label>
        <input type="file" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
      file:rounded-lg file:border-0
      file:text-sm file:font-semibold
      file:bg-[#D6C6B8] file:text-[#3E3A39]
      hover:file:bg-[#BFA6A0]">
        <p class="text-xs text-[#3E3A39] mt-1">Upload 1 atau lebih foto produk (maks 5 MB per file)</p>
    </div>

    <!-- Clean Formula -->
    <!--<div class="mb-4">
        <label class="flex items-center gap-2 text-[#3E3A39]">
            <input type="checkbox" class="rounded text-[#9BAF9A] focus:ring-[#9BAF9A]" />
            Clean Formula
        </label>
    </div>-->

    <!-- Aktifkan Produk -->
    <!--<div class="mb-6">
        <label class="flex items-center gap-2 text-[#3E3A39]">
            <input type="checkbox" checked class="rounded text-[#9BAF9A] focus:ring-[#9BAF9A]" />
            Aktifkan Produk
        </label>
    </div> -->

    <!-- Tombol Submit -->
    <a href="{{ route('produk.index') }}" class="bg-[#9BAF9A] hover:bg-[#8DA089] text-white font-semibold px-6 py-2 rounded-lg shadow transition-all">
        Tambah Produk
    </a>
</div>
@endsection