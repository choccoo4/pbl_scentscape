@extends('layouts.app')

@section('title', 'Best Sellers - Scentscape')

@section('content')
<!-- Hero Section -->
<x-herosection
    background="{{ asset('images/hero-home.png') }}"
    title="Best Sellers"
    subtitle="Not sure where to begin? Explore our most loved fragrances, chosen by our loyal customers." />

@php
$products = [
[
'name' => 'Floraison',
'price' => 'Rp 401.000',
'img' => 'image.png',
'gender' => 'For Her',
'volume' => '50ml',
'type' => 'EDP',
'aromas' => [
['icon' => 'flower', 'label' => 'Floral'],
['icon' => 'drop', 'label' => 'Watery'],
],
'slug' => 'floraison',
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
'slug' => 'floraison',
],
[
'name' => 'Beige 96',
'price' => 'Rp 401.000',
'img' => 'image3.png',
'gender' => 'For Him',
'volume' => '75ml',
'type' => 'Parfum',
'aromas' => [
['icon' => 'fire', 'label' => 'Spicy'],
['icon' => 'drop', 'label' => 'Aquatic'],
['icon' => 'smiley', 'label' => 'Playful'],
],
'slug' => 'floraison',
],
[
'name' => 'Almalika',
'price' => 'Rp 401.000',
'img' => 'image4.png',
'gender' => 'Unisex',
'volume' => '50ml',
'type' => 'EDP',
'aromas' => [
['icon' => 'crown', 'label' => 'Royal Oud'],
['icon' => 'flower', 'label' => 'Rose'],
],
'slug' => 'floraison',
],
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
'slug' => 'floraison',
],
];
@endphp

<!-- Card Produk -->
<section class="bg-[#f2ede4] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
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
    </div>
</section>
@endsection