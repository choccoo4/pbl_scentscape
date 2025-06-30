@extends('layouts.app')

@section('title', 'Best Sellers - Scentscape')

@section('content')
<!-- Hero Section -->
<x-herosection
    background="{{ asset('images/hero-home.png') }}"
    title="Best Sellers"
    subtitle="Not sure where to begin? Explore our most loved fragrances, chosen by our loyal customers." />

<!-- Card Produk -->
<section class="bg-[#f2ede4] py-10">
    <div class="max-w-screen-xl mx-auto">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-x-2 gap-y-4 px-2 xl:px-4">
            @foreach ($products as $product)
            <x-product_card
                id="{{ $product['id'] }}"
                name="{{ $product['name'] }}"
                price="{{ $product['price'] }}"
                image="{{ asset('storage/' . $product['img']) }}"
                gender="{{ $product['gender'] }}"
                volume="{{ $product['volume'] }}"
                type="{{ $product['type'] }}"
                type_full="{{ $product['type_full'] }}"
                :aroma="$product['aroma']"
                stok="{{ $product['stok'] }}"
                extraClass="border border-gray-300"
                slug="{{ $product['slug'] }}" />
            @endforeach
        </div>
    </div>
</section>

@endsection