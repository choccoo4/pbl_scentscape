@extends('layouts.seller')
@section('title', 'Daftar Produk - Scentscape')

@section('content')
<div class="pt-4 px-6 min-h-screen bg-beige-100">
    <!-- Judul -->
    <h1 class="text-2xl mb-4 flex items-center gap-2">
        <i class="fa-solid fa-box mr-2"></i> Daftar Produk
    </h1>
    <hr class="mb-6 border-gray-400">

    <!-- Baris Tambah Produk & Search -->
    <div class="flex justify-between items-center w-full flex-wrap gap-2 mb-6">
        <a href="{{ route('tambahproduk') }}"
            class="bg-[#9BAF9A] hover:bg-[#819b83] text-white px-4 py-2 rounded-md text-sm transition shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
        <input type="text" placeholder="Cari produk..."
            class="rounded-md px-3 py-2 bg-[#F6F1EB] border border-[#D6C6B8] text-sm text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#BFA6A0] w-full max-w-xs transition">
    </div>

    <!-- Table -->
    <table class="w-full text-sm text-gray-700 border-collapse text-center">
        <thead class="bg-[#D6C6B8] text-[#3E3A39] text-sm uppercase tracking-wide">
            <tr class="border-b border-[#D6C6B8] hover:bg-[#F6F1EB] transition hover:scale-[1.01]">
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
            @php
            $page = request()->get('page', 1);
            $start = ($page - 1) * 5 + 1;
            @endphp

            @php
            $productImages = [
            'image2-1.jpg',
            'image2-2.jpg',
            'image2-3.jpg',
            'image2-4.jpg',
            'image7.jpg',
            'image8 (1).jpg',
            'image8 (2).jpg',
            'image8 (3).jpg',
            'image8 (4).jpg',
            'image9 (1).jpg',
            'image9 (2).jpg',
            'image9 (3).jpg',
            'image9 (4).jpg',
            'image9 (5).jpg',
            'image10 (1).jpg',
            'image10 (2).jpg',
            'image10 (3).jpg',
            'image11 (1).jpg',
            'image11 (2).jpg',
            'image11 (3).jpg',
            'image11 (4).jpg',
            ];
            @endphp

            @for ($i = $start; $i < $start + 5; $i++)
                <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $i }}</td>
                <td class="p-3">
                    <img src="{{ asset('images/products/' . $productImages[($i - 1) % count($productImages)]) }}"
                        class="w-12 h-12 object-cover rounded">
                </td>
                <td class="p-3">Produk {{ $i }}</td>
                <td class="p-3">{{ rand(1, 10) }} Unit</td>
                <td class="p-3">Rp{{ number_format(100000 + $i * 1000, 0, ',', '.') }}</td>
                <td class="p-3">{{ rand(5, 20) }}</td>
                <td class="p-3">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('updateproduk') }}"
                            class="bg-[#BFA6A0] hover:bg-[#a78c87] text-white px-3 py-1 rounded text-xs transition">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
                </tr>
                @endfor
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pt-4 flex justify-center">
        <div class="flex gap-2 text-sm">
            <a href="?page=1"
                class="{{ request()->get('page', 1) == 1 ? 'bg-[#9BAF9A] text-white' : 'bg-[#D6C6B8] text-[#3E3A39] hover:bg-[#c9b6aa]' }} px-3 py-1 rounded-md shadow-sm">
                1
            </a>
            <a href="?page=2"
                class="{{ request()->get('page') == 2 ? 'bg-[#9BAF9A] text-white' : 'bg-[#D6C6B8] text-[#3E3A39] hover:bg-[#c9b6aa]' }} px-3 py-1 rounded-md shadow-sm">
                2
            </a>
            <a href="?page={{ request()->get('page', 1) + 1 }}"
                class="px-3 py-1 bg-[#D6C6B8] text-[#3E3A39] rounded-md hover:bg-[#c9b6aa] cursor-pointer shadow-sm">
                &gt;
            </a>
        </div>
    </div>
</div>
@endsection