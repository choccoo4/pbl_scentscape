@extends('layouts.seller')
@section('title', 'Product List - Scentscape')

@section('content')
<div class="pt-4 px-6 min-h-screen bg-beige-100">
    <!-- Title -->
    <h1 class="text-2xl mb-4 flex items-center gap-2">
        <i class="fa-solid fa-box mr-2"></i> Product List
    </h1>
    <hr class="mb-6 border-gray-400">

    <!-- Add Product & Search Bar -->
    <div class="flex justify-between items-center w-full flex-wrap gap-2 mb-6">
        <a href="{{ route('produk.create') }}"
           class="bg-[#9BAF9A] hover:bg-[#819b83] text-white px-4 py-2 rounded-md text-sm transition shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Product
        </a>
        <form action="{{ route('produk.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search product..."
                   class="rounded-md px-3 py-2 bg-[#F6F1EB] border border-[#D6C6B8] text-sm text-[#3E3A39] focus:outline-none focus:ring-2 focus:ring-[#BFA6A0] w-full max-w-xs transition">
            <button type="submit"
                    class="bg-[#9BAF9A] hover:bg-[#819b83] text-white px-4 py-2 rounded-md text-sm transition shadow-sm">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Product Table -->
    <table class="w-full text-sm text-gray-700 border-collapse text-center">
        <thead class="bg-[#D6C6B8] text-[#3E3A39] text-sm uppercase tracking-wide">
            <tr class="border-b border-[#D6C6B8] hover:bg-[#F6F1EB] transition hover:scale-[1.01]">
                <th class="p-3">No</th>
                <th class="p-3">Photo</th>
                <th class="p-3">Product Name</th>
                <th class="p-3">Sales</th>
                <th class="p-3">Price</th>
                <th class="p-3">Stock</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $index => $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $produk->firstItem() + $index }}</td>
                    <td class="p-3">
                        <img src="{{ asset('storage/' . ($item->gambar[0] ?? 'default.jpg')) }}"
                             class="w-12 h-12 object-cover rounded"
                             alt="{{ $item->nama_produk }}">
                    </td>
                    <td class="p-3">{{ $item->nama_produk }}</td>
                    <td class="p-3">{{ $item->penjualan }} Units</td>
                    <td class="p-3">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="p-3">{{ $item->stok }}</td>
                    <td class="p-3">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('produk.edit', $item->no_produk) }}"
                               class="bg-[#BFA6A0] hover:bg-[#a78c87] text-white px-3 py-1 rounded text-xs transition">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('produk.destroy', $item->no_produk) }}" method="POST" class="delete-produk">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Custom Pagination -->
    <div class="pt-6 flex justify-center">
        {{ $produk->onEachSide(1)->links('vendor.pagination.tailwind-custom') }}
    </div>
</div>
@endsection
