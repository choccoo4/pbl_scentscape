@extends('layouts.app')

@section('title', 'Shop - Scentscape')

@section('content')
<section class="bg-[#f4f0e9] min-h-screen py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        {{-- Bagian Gambar --}}
        @php
        $images = [
        'image2-2.jpg',
        'image2-1.jpg',
        'image2-4.jpg',
        'image2-3.jpg',
        ];
        @endphp

        <div x-data="{ current: 0, images: {{ json_encode($images) }} }" class="flex flex-col items-center">
            <div class="relative w-[300px]">
                <img :src="'/images/products/' + images[current]" alt="" class="rounded-xl w-full h-auto">
                <button @click="current = (current - 1 + images.length) % images.length"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white/70 p-2 rounded-full shadow">
                    ‹
                </button>
                <button @click="current = (current + 1) % images.length"
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white/70 p-2 rounded-full shadow">
                    ›
                </button>
            </div>

            <div class="flex mt-4 space-x-2">
                <template x-for="(img, index) in images" :key="index">
                    <img :src="'/images/products/' + img"
                        @click="current = index"
                        :class="current === index ? 'ring-2 ring-[#9BAF9A]' : ''"
                        class="w-16 h-16 object-cover rounded cursor-pointer transition-all duration-200">
                </template>
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="text-gray-800 px-4 sm:px-20 md:px-20 lg:px-0">
            <h2 class="text-2xl font-semibold text-center lg:text-left">
                Ethereal Thermal - 50ml Eau De Parfum
            </h2>
            <p class="text-lg font-semibold text-gray-700 mt-2 text-center lg:text-left">
                Rp 401.000
            </p>

            <hr class="my-4 border-gray-300">

            {{-- Paragraf utama --}}
            <p>
                A fragrance that responds to the unique warmth of each individual. Dancing between the cool and warm, we discovered the magic notes of bergamot citrus and spice on cooler skin. While warm bodies revealed the rich symphony of Amber, musk, and suede.
            </p>

            <br>

            {{-- Penekanan karakter pemakai --}}
            <div>
                <p class="font-semibold">You will love this if you are:</p>
                <p>
                    A curious soul who loves to explore with a stylish touch, and you want to smell different from everyone else to be unique and desirable.
                </p>
            </div>

            <br>

            {{-- Notes --}}
            <div class="space-y-1">
                <p><span class="font-semibold">Top</span> : Bergamot Cassis Rose</p>
                <p><span class="font-semibold">Middle</span> : Suede Violet Sandalwood</p>
                <p><span class="font-semibold">Base</span> : Vetiver Vanilla White Musk</p>
            </div>

            {{-- Jumlah & Tombol --}}
            <div class="flex items-center space-x-4 mt-8">
                <div class="flex items-center border rounded px-2 py-1 bg-white shadow-sm">
                    <button class="px-2 text-lg font-bold text-gray-600">-</button>
                    <span class="px-4 text-md">1</span>
                    <button class="px-2 text-lg font-bold text-gray-600">+</button>
                </div>

                <button class="bg-[#9BAF9A] hover:bg-[#88a488] text-white font-semibold px-6 py-2 rounded transition-all">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</section>

{{-- Section: What Others Say --}}
<!--<section class="max-w-6xl mx-auto mt-20 px-4">
    <h3 class="text-xl font-semibold mb-4 text-[#3E3A39]">What Others Say</h3>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
        <div class="bg-white p-4 rounded-lg shadow">
            <p>“Warm yet fresh, this scent feels like a hug after rain.”</p>
            <p class="mt-2 text-right font-semibold text-xs text-[#9BAF9A]">— Alia, Jakarta</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p>“I wore this on a date, and they asked me what perfume I use 👀”</p>
            <p class="mt-2 text-right font-semibold text-xs text-[#9BAF9A]">— Miko, Bandung</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p>“Perfect for both chill weekends and semi-formal events.”</p>
            <p class="mt-2 text-right font-semibold text-xs text-[#9BAF9A]">— Nadine, Bali</p>
        </div>
    </div>
</section>-->

@php
$products = [
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
];
@endphp

<div class="max-w-4xl mx-auto px-6 py-12 space-y-10 text-[#3E3A39]">
    {{-- Fragrance Vibe --}}
    <!--<section class="bg-[#F6F1EB] rounded-xl p-6 shadow-md">
        <h2 class="text-xl font-semibold mb-4">Fragrance Vibe</h2>
        <div class="flex flex-wrap gap-4">
            <span class="bg-[#D6C6B8] text-sm font-medium px-4 py-2 rounded-full shadow">🌙 Nighttime Vibe</span>
            <span class="bg-[#BFA6A0] text-sm font-medium px-4 py-2 rounded-full shadow">🔥 Warm & Sensual</span>
            <span class="bg-[#9BAF9A] text-sm font-medium px-4 py-2 rounded-full shadow">🕯️ Mysterious & Bold</span>
        </div>
    </section>-->

    {{-- Usage Tips --}}
    <section class="bg-[#F6F1EB] rounded-xl p-6 shadow-md">
        <h2 class="text-xl font-semibold mb-4">Usage Tips</h2>
        <ul class="list-disc list-inside space-y-2 text-base">
            <li>Semprot di titik nadi: pergelangan tangan, leher, belakang telinga.</li>
            <li>Gunakan setelah mandi agar aroma lebih tahan lama.</li>
        </ul>
    </section>

    {{-- Clean Formula --}}
    <section class="bg-[#F6F1EB] rounded-xl p-6 shadow-md text-center items-center">
        <h2 class="text-xl font-semibold mb-4">Clean Formula</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#9BAF9A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Vegan Friendly
            </div>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#9BAF9A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 2a8 8 0 110 16 8 8 0 010-16z"/>
                </svg>
                No Alcohol
            </div>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#9BAF9A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 4v16m8-8H4" />
                </svg>
                Skin Safe
            </div>
        </div>
    </section>

    {{-- Behind the Scent --}} 
    <!--<section class="bg-[#F6F1EB] rounded-xl p-6 shadow-md">
        <h2 class="text-xl font-semibold mb-4">Behind the Scent</h2>
        <p class="text-base leading-relaxed">
            Terinspirasi dari kehangatan matahari senja dan aroma angin sore, parfum ini diciptakan untuk menghadirkan nuansa ketenangan dan pesona yang abadi.
            Dirancang sebagai wewangian harian yang elegan, cocok untuk kamu yang ingin tampil lembut namun berkarakter.
        </p>
    </section>-->
</div>

{{-- Section: Pair it with --}}
<section class="max-w-6xl mx-auto mt-20 px-4">
    <h3 class="text-xl font-semibold mb-4 text-[#3E3A39]">Pair it with</h3>
    <div class="flex gap-4 overflow-x-auto pb-4">
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
                    extraClass="border border-gray-200 w-60 shrink-0" />
            </a>
        @endforeach
        <div class="h-20"></div>
    </div>
</section>

@endsection