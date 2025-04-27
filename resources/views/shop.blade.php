@extends('layouts.pembeli')

@section('title', 'Shop - Scentscape')

@section('content')
<section class="bg-[#f2ede4] min-h-screen px-4 md:px-10 py-10">
    {{-- Judul --}}
    <h2 class="text-center font-playfair font-semibold text-lg text-gray-800 mb-4">Products</h2>

    {{-- Garis & Sort --}}
    <div class="flex items-center border-t border-b border-gray-500/30 text-sm text-gray-700">
        <div class="flex-grow"></div>

        <div x-data="{ open: false }" class="relative border-l border-gray-500/30 text-sm text-gray-700">
            <button @click="open = !open"
                class="flex items-center gap-1 px-4 py-2 w-full hover:text-gray-900 transition">
                Sort
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 text-gray-700 transition-transform"
                    fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul x-show="open" @click.away="open = false"
                class="absolute right-0 mt-1 w-48 bg-white shadow-md rounded-md border border-gray-200 z-50">
                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Price: Low to High</a></li>
                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Price: High to Low</a></li>
                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Newest</a></li>
            </ul>
        </div>
    </div>

    {{-- Grid Produk --}}
    <div class="grid pt-5 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
        <div class="border border-black/40 rounded-md overflow-hidden">
            <div class="aspect-square bg-white">
                <img src="/images/products/image2.png" alt="Floraison" class="w-full h-full object-cover">
            </div>
            <div class="text-center py-3 px-2">
                <h3 class="font-poppins text-sm text-gray-800">Floraison</h3>
                <p class="font-poppins text-sm text-gray-600">Rp 401.000</p>
            </div>
        </div>
        <div class="border border-black/40 rounded-md overflow-hidden">
            <div class="aspect-square bg-white">
                <img src="/images/products/image3.png" alt="Floraison" class="w-full h-full object-cover">
            </div>
            <div class="text-center py-3 px-2">
                <h3 class="font-poppins text-sm text-gray-800">Floraison</h3>
                <p class="font-poppins text-sm text-gray-600">Rp 401.000</p>
            </div>
        </div>
        <div class="border border-black/40 rounded-md overflow-hidden">
            <div class="aspect-square bg-white">
                <img src="/images/products/image4.png" alt="Floraison" class="w-full h-full object-cover">
            </div>
            <div class="text-center py-3 px-2">
                <h3 class="font-poppins text-sm text-gray-800">Floraison</h3>
                <p class="font-poppins text-sm text-gray-600">Rp 401.000</p>
            </div>
        </div>
        <div class="border border-black/40 rounded-md overflow-hidden">
            <div class="aspect-square bg-white">
                <img src="/images/products/image5.png" alt="Floraison" class="w-full h-full object-cover">
            </div>
            <div class="text-center py-3 px-2">
                <h3 class="font-poppins text-sm text-gray-800">Floraison</h3>
                <p class="font-poppins text-sm text-gray-600">Rp 401.000</p>
            </div>
        </div>
        <div class="border border-black/40 rounded-md overflow-hidden">
            <div class="aspect-square bg-white">
                <img src="/images/products/image.png" alt="Floraison" class="w-full h-full object-cover">
            </div>
            <div class="text-center py-3 px-2">
                <h3 class="font-poppins text-sm text-gray-800">Floraison</h3>
                <p class="font-poppins text-sm text-gray-600">Rp 401.000</p>
            </div>
        </div>
    </div>
</section>


@endsection