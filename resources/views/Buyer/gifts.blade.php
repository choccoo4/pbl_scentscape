@extends('layouts.app')

@section('title', 'Gifts - Scentscape')

@section('content')
<!-- Hero Section -->
<x-herosection
    background="{{ asset('images/hero-home.png') }}"
    title="Gifts"
    subtitle="Share the timeless beauty of fragrance with someone special." />

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


<section class="bg-[#f2ede4] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
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
                    extraClass="border border-gray-300" />
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection