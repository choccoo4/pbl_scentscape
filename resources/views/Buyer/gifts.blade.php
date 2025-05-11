@extends('layouts.app')

@section('title', 'Gifts - Scentscape')

@section('content')
<!-- Hero Section -->
<x-herosection
    background="{{ asset('images/hero-home.png') }}"
    title="Gifts"
    subtitle="Share the timeless beauty of fragrance with someone special." />

<section class="bg-[#f2ede4] py-10">
<div class="max-w-screen-xl mx-auto">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-x-2 gap-y-4 px-2 xl:px-4">
            @foreach ($products as $product)
            <a href="{{ route('product-detail', ['slug' => $product['slug']]) }}">
                <x-product-card extraClass="border border-red-500"
                    name="{{ $product['name'] }}"
                    price="{{ $product['price'] }}"
                    image="{{ asset('images/products/' . $product['img']) }}"
                    gender="{{ $product['gender'] }}"
                    volume="{{ $product['volume'] }}"
                    type="{{ $product['type'] }}"
                    :aromas="$product['aromas']"
                    extraClass="border border-gray-300" />
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection