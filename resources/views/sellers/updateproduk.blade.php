@extends('layouts.penjual')

@section('content')
<div class="px-6 pt-4 pb-10">
    <!-- Judul -->
    <!-- Judul -->
    <h1 class="text-2xl mb-4 flex items-center gap-2">☰ Update Produk</h1>
    <hr class="mb-6 border-gray-400">

    <!-- Form -->
    <form action="#" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md w-full max-w-full">
        @csrf
        <h2 class="text-lg font-semibold mb-4 border-b border-gray-400 pb-2">Data Produk</h2>

        <!-- Kategori -->
        <div class="mb-4">
            <label for="kategori" class="block mb-1 font-medium text-sm">Kategori :</label>
            <select id="kategori" name="kategori" class="w-full border rounded px-3 py-2 bg-[#f5f5dc]">
                <option value="women">Women</option>
                <option value="men">Men</option>
                <option value="unisex">Unisex</option>
            </select>
        </div>

        <!-- Nama Produk -->
        <div class="mb-4">
            <label for="nama_produk" class="block mb-1 font-medium text-sm">Nama Produk:</label>
            <input type="text" id="nama_produk" name="nama_produk" class="w-full border rounded px-3 py-2 bg-[#f5f5dc]" placeholder="Contoh: Ethereal - Parfume 30ml">
        </div>

        <!-- Ukuran -->
        <div class="mb-4">
            <label for="ukuran" class="block mb-1 font-medium text-sm">Ukuran:</label>
            <input type="text" id="ukuran" name="ukuran" class="w-full border rounded px-3 py-2 bg-[#f5f5dc]" placeholder="Contoh: 70ml">
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
            <label for="deskripsi" class="block mb-1 font-medium text-sm">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full border rounded px-3 py-2 bg-[#f5f5dc]" placeholder="Deskripsikan aroma, karakter, dan keunggulan produk..."></textarea>
        </div>

        <!-- Harga & Stok -->
        <div class="mb-4 flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/2">
                <label for="harga" class="block mb-1 font-medium text-sm">Harga:</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 bg-gray-200 border border-r-0 rounded-l text-gray-600">Rp</span>
                    <input type="number" id="harga" name="harga" class="w-full border rounded-r px-3 py-2 bg-[#f5f5dc]" placeholder="105000">
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <label for="stok" class="block mb-1 font-medium text-sm">Stok:</label>
                <input type="number" id="stok" name="stok" class="w-full border rounded px-3 py-2 bg-[#f5f5dc]" placeholder="Contoh: 7">
            </div>
        </div>

        <!-- Foto -->
        <div class="mb-6">
            <label for="foto" class="block mb-1 font-medium text-sm">Foto:</label>
            <input type="file" id="foto" name="foto" class="w-full border rounded px-3 py-2 bg-[#f5f5dc]">
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded text-sm">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
