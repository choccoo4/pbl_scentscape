@extends('layouts.pembeli')

@section('title', 'Gifts - Scentscape')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] md:h-[500px] lg:h-[550px] overflow-hidden">
    <img src="{{ asset('images/hero-gifts.jpg') }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover z-0" />
    <div class="absolute inset-0 bg-black/30 z-10"></div>
    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center text-white px-4">
        <h1 class="text-2xl md:text-4xl font-semibold mb-3">Gifts</h1>
        <p class="text-sm md:text-lg max-w-xl leading-relaxed">
        Share the timeless beauty of fragrance with someone special.</p>
    </div>
</section>

<section class="bg-[#f2ede4] min-h-screen px-4 md:px-10 py-10">
{{-- Grid Produk --}}
    <div class="grid pt-5 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
        <div class="border border-black/40 rounded-md overflow-hidden">
            <div class="aspect-square bg-white">
                <img src="/images/products/image6.jpg" alt="Scent Designer Kit" class="w-full h-full object-cover">
            </div>
            <div class="text-center py-3 px-2">
                <h3 class="font-poppins text-sm text-gray-800">Scent Designer Kit</h3>
                <p class="font-poppins text-sm text-gray-600">Rp 180.000</p>
            </div>
        </div>
        <div class="border border-black/40 rounded-md overflow-hidden">
            <div class="aspect-square bg-white">
                <img src="/images/products/image7.jpg" alt="Make it gift" class="w-full h-full object-cover">
            </div>
            <div class="text-center py-3 px-2">
                <h3 class="font-poppins text-sm text-gray-800">Make it gift</h3>
                <p class="font-poppins text-sm text-gray-600">Rp 90.000</p>
            </div>
        </div>
    </div>
</section>


@endsection
