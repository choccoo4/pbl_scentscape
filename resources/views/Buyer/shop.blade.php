@extends('layouts.app')

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

    @php
    $products = [
    [
    'name' => 'La Bohème',
    'price' => 'Rp 401.000',
    'img' => 'image5.png',
    'gender' => 'For Her',
    'volume' => '40ml',
    'type' => 'EDT',
    'aromas' => [
    ['icon' => 'sparkle', 'label' => 'Bright'],
    ['icon' => 'star', 'label' => 'Powdery'],
    ],
    'slug' => 'la-boheme',
    ],
    [
    'name' => 'Scent Designer Kit',
    'price' => 'Rp 180.000',
    'img' => 'image6.jpg',
    'gender' => 'Unisex',
    'volume' => '50ml',
    'type' => 'EDP',
    'aromas' => [
    ['icon' => 'palette', 'label' => 'Creative'],
    ['icon' => 'drop', 'label' => 'Fresh'],
    ],
    'slug' => 'scent-designer-kit',
    ],
    [
    'name' => 'Make it Gift',
    'price' => 'Rp 90.000',
    'img' => 'image7.jpg',
    'gender' => 'Gift Set',
    'volume' => '–',
    'type' => 'Bundle',
    'aromas' => [
    ['icon' => 'gift', 'label' => 'Special'],
    ['icon' => 'heart', 'label' => 'Romantic'],
    ],
    'slug' => 'make-it-gift',
    ],
    [
    'name' => 'Ethereal',
    'price' => 'Rp 401.000',
    'img' => 'image2.png',
    'gender' => 'Unisex',
    'volume' => '30ml',
    'type' => 'EDT',
    'aromas' => [
    ['icon' => 'leaf', 'label' => 'Green'],
    ['icon' => 'sparkle', 'label' => 'Fresh'],
    ],
    'slug' => 'ethereal',
    ],
    [
    'name' => 'Midnight Bloom',
    'price' => 'Rp 355.000',
    'img' => 'image3.png',
    'gender' => 'For Her',
    'volume' => '50ml',
    'type' => 'EDP',
    'aromas' => [
    ['icon' => 'flower', 'label' => 'Floral'],
    ['icon' => 'moon', 'label' => 'Mystic'],
    ],
    'slug' => 'midnight-bloom',
    ],
    [
    'name' => 'Golden Hour',
    'price' => 'Rp 390.000',
    'img' => 'image4.png',
    'gender' => 'Unisex',
    'volume' => '40ml',
    'type' => 'EDT',
    'aromas' => [
    ['icon' => 'sun', 'label' => 'Warm'],
    ['icon' => 'orange', 'label' => 'Citrus'],
    ],
    'slug' => 'golden-hour',
    ],
    ];
    @endphp


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mt-5">
        @foreach ($products as $product)
        <a href="{{ route('product-detail', ['slug' => $product['slug']]) }}">
            <x-product-card
                name="{{ $product['name'] }}"
                price="{{ $product['price'] }}"
                image="{{ asset('images/products/' . $product['img']) }}"
                gender="{{ $product['gender'] }}"
                volume="{{ $product['volume'] }}"
                type="{{ $product['type'] }}"
                :aromas="$product['aromas']"
                extraClass="border border-gray-300 w-60" />
        </a>
        @endforeach
    </div>
</section>
@endsection