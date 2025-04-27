@extends('layouts.app')

@section('title', 'Home - Scentscape')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] md:h-[500px] lg:h-[550px] overflow-hidden">
    <img src="{{ asset('images/hero-home.png') }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover z-0" />
    <div class="absolute inset-0 bg-black/30 z-10"></div>
    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center text-white px-4">
        <h1 class="text-2xl md:text-4xl font-semibold mb-3">Scents that Speak Softly</h1>
        <p class="text-sm md:text-lg max-w-xl leading-relaxed">
            A curated selection of fragrances with feminine nuances,<br>
            made for every person, every moment.
        </p>
    </div>
</section>

<!-- Latest Releases -->
<section class="bg-[#f4f0ea] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800">Latest releases</h2>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-800 font-medium">SEE MORE</a>
        </div>

        <!-- Product Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @foreach ([
                ['name' => 'Floraison', 'price' => 'Rp 401.000', 'color' => 'border-pink-300', 'img' => 'image.png'],
                ['name' => 'Ethereal', 'price' => 'Rp 401.000', 'color' => 'border-blue-200', 'img' => 'image2.png'],
                ['name' => 'Beige 96', 'price' => 'Rp 401.000', 'color' => 'border-yellow-300', 'img' => 'image3.png'],
                ['name' => 'Almalika', 'price' => 'Rp 401.000', 'color' => 'border-purple-300', 'img' => 'image4.png'],
                ['name' => 'La Bohème', 'price' => 'Rp 401.000', 'color' => 'border-green-300', 'img' => 'image5.png']
            ] as $product)
                <div class="border-t-4 {{ $product['color'] }} bg-white rounded-md shadow-sm overflow-hidden">
                    <img src="{{ asset('images/products/' . $product['img']) }}" alt="{{ $product['name'] }}" class="w-full h-[200px] object-contain p-4">
                    <div class="px-4 pb-4">
                        <h3 class="text-center text-sm font-medium text-gray-800">{{ $product['name'] }}</h3>
                        <p class="text-center text-sm text-gray-500">{{ $product['price'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
