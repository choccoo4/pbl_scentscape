@extends('layouts.penjual')

@section('content')
<div class="pt-4 px-6 min-h-screen bg-beige-100">
    <!-- Judul -->
    <h1 class="text-2xl mb-4 flex items-center gap-2">
    <i class="fa-solid fa-box mr-2"></i> Daftar Produk</h1>
    <hr class="mb-6 border-gray-400">
    <!-- Baris Tambah Produk & Search -->
    <div class="flex justify-between items-center w-full flex-wrap gap-2 mb-6">
    <a href="{{ route('tambahproduk') }}"
       class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm text-center whitespace-nowrap">
        + Tambah Produk
    </a>
    <input type="text" placeholder="Search..."
           class="rounded px-3 py-2 bg-white border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-brown-600 w-full max-w-xs">
</div>




    <!-- Table -->
    <table class="w-full text-left text-sm text-gray-700 border-collapse">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="p-3">No</th>
                <th class="p-3">Foto</th>
                <th class="p-3">Nama Produk</th>
                <th class="p-3">Penjualan</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Stok</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 5; $i++)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $i }}</td>
                <td class="p-3">
                    <img src="https://via.placeholder.com/50" class="w-12 h-12 object-cover rounded">
                </td>
                <td class="p-3">Produk {{ $i }}</td>
                <td class="p-3">3 Unit</td>
                <td class="p-3">Rp105.615</td>
                <td class="p-3">10</td>
                <td class="p-3">
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('updateproduk') }}" class="bg-gray-700 text-white px-3 py-1 rounded text-xs hover:bg-gray-800 text-center">Edit</a>
                        <button class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 text-center">Hapus</button>
                    </div>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pt-4 flex justify-center">
        <div class="flex gap-2 text-sm">
            <span class="px-2 py-1 bg-gray-800 text-white rounded">1</span>
            <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded">2</span>
            <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded">&gt;</span>
        </div>
    </div>
</div>
@endsection
