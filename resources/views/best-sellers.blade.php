@extends('layouts.pembeli')

@section('title', 'Best Sellers - Scentscape')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] md:h-[500px] lg:h-[550px] overflow-hidden">
    <img src="{{ asset('images/hero-home.png') }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover z-0" />
    <div class="absolute inset-0 bg-black/30 z-10"></div>
    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center text-white px-4">
        <h1 class="text-2xl md:text-4xl font-semibold mb-3">Best Sellers</h1>
        <p class="text-sm md:text-lg max-w-xl leading-relaxed">
        Not sure where to begin? Explore our most loved fragrances, chosen by our loyal customers.
        </p>
    </div>
</section>

<section class="bg-[#f2ede4] min-h-screen px-4 md:px-10 py-10">
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
