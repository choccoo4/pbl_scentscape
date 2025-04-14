@extends('layouts.pembeli')

@section('title', 'Shop - Scentscape')

@section('content')
<section class="bg-[#f4f0e9] min-h-screen py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        {{-- Bagian Gambar --}}
        <div class="flex flex-col items-center">
            <img src="{{ asset('images/products/image2-2.jpg') }}" alt="Almalika" class="rounded-xl w-[300px] mb-6">

            <div class="flex space-x-4">
                <img src="{{ asset('images/products/image2-1.jpg') }}" alt="Thumb 1" class="w-20 h-20 object-cover rounded cursor-pointer">
                <img src="{{ asset('images/products/image2-4.jpg') }}" alt="Thumb 2" class="w-20 h-20 object-cover rounded cursor-pointer">
                <img src="{{ asset('images/products/image2-3.jpg') }}" alt="Thumb 3" class="w-20 h-20 object-cover rounded cursor-pointer">
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
            <div class="flex items-center space-x-4 mt-6">
                <div class="flex items-center border rounded px-2 py-1 bg-white">
                    <button class="px-2 text-lg">-</button>
                    <span class="px-2">1</span>
                    <button class="px-2 text-lg">+</button>
                </div>

                <button class="bg-gray-300 hover:bg-gray-400 text-black px-6 py-2 rounded transition-all">
                    ADD TO CART
                </button>
            </div>
        </div>
    </div>
</section>

@endsection