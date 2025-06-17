@extends('layouts.app')

@section('title', 'Home - Scentscape')

@section('content')
<!-- Hero Section -->
<x-herosection
  background="{{ asset('images/hero-home.png') }}"
  title="Scents that Speak Softly"
  subtitle="A curated selection of fragrances with feminine nuances,<br>made for every person, every moment." />
<!-- Latest Releases -->
<section class="bg-[#f2ede4] py-16 px-6">
  <!-- Header & SEE MORE dibatasi max width -->
  <div class="max-w-screen-xl mx-auto px-5">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-lg md:text-xl font-semibold text-gray-800 font-serif">Latest releases</h2>
      <a href="{{ route('shop')}}" class="text-sm text-gray-600 hover:text-gray-800 font-medium font-serif">SEE MORE</a>
    </div>
  </div>

  <!-- Grid produk dibuat keluar dari max-w agar bisa nempel kiri -->
  <div class="px-4">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-x-4 gap-y-6">
      @foreach ($products as $product)
      <x-product-card
        id="{{ $product['id'] }}"
        name="{{ $product['name'] }}"
        price="{{ $product['price'] }}"
        image="{{ asset('storage/' . $product['img']) }}"
        gender="{{ $product['gender'] }}"
        volume="{{ $product['volume'] }}"
        type="{{ $product['type'] }}"
        type_full="{{ $product['type_full'] }}"
        :aroma="$product['aroma']"
        extraClass="border border-gray-300"
        slug="{{ $product['slug'] }}" />
      @endforeach
    </div>
  </div>
</section>

<section class="bg-[#f2ede4] py-16 px-6 text-center">
  <h2 class="text-3xl font-semibold text-gray-900 mb-3 font-serif">Ingredients</h2>
  <p class="text-gray-600 max-w-xl mx-auto mb-8">
    Discover the 12 core scent families and explore the wide world of perfumes built around them.
  </p>

  <div class="flex justify-center flex-wrap gap-6 mb-8">
    @foreach ($ingredients as $item)
    <div class="flex flex-col items-center w-20">
      <div class="w-20 h-20 rounded-full overflow-hidden border border-gray-200">
        <img src="{{ asset('storage/aroma/' . $item['img']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover" />
      </div>
      <p class="mt-2 text-sm text-gray-800 font-medium">{{ $item['name'] }}</p>
    </div>
    @endforeach
  </div>
</section>

<section class="bg-[#f6f1eb] py-16 px-6">
  <div class="max-w-7xl mx-auto text-center">
    <h2 class="text-3xl font-serif font-semibold text-gray-900 mb-8">Why Scentscape?</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
      <div>
        <img src="{{ asset('images/icons/crueltyfree.png') }}" alt="Cruelty Free" class="mx-auto w-20 h-20 mb-3" />
        <p class="font-medium text-gray-800 text-sm">Cruelty-Free</p>
      </div>
      <div>
        <img src="{{ asset('images/icons/natural.jpeg') }}" alt="Natural Ingredients" class="mx-auto w-20 h-20 mb-3" />
        <p class="font-medium text-gray-800 text-sm">Natural Ingredients</p>
      </div>
      <div>
        <img src="{{ asset('images/icons/lasting.jpeg') }}" alt="Long Lasting" class="mx-auto w-20 h-20 mb-3" />
        <p class="font-medium text-gray-800 text-sm">Long Lasting</p>
      </div>
      <div>
        <img src="{{ asset('images/icons/diamond.jpeg') }}" alt="Elegant Scents" class="mx-auto w-20 h-20 mb-3" />
        <p class="font-medium text-gray-800 text-sm">Elegant Scents</p>
      </div>
    </div>
  </div>
</section>

<section class="bg-[#d6c6b8] py-16 px-6">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-3xl font-serif font-semibold text-gray-900 mb-10">Best Sellers</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      @foreach ($bestSellers as $product)
      <div class="flex flex-col md:flex-row items-center bg-white rounded-lg overflow-hidden shadow-md">
        <img src="{{ asset('storage/' . $product['img']) }}" alt="{{ $product['name'] }}" class="w-full md:w-1/2 h-60 object-cover" />
        <div class="p-6 text-left">
          <h3 class="text-lg font-serif font-semibold text-gray-900">{{ $product['name'] }}</h3>
          <p class="text-gray-700 text-sm mt-2 mb-4">{{ $product['deskripsi'] }}</p>
          <a href="{{ route('produk.show', $product['id']) }}" class="text-[#3e3a39] font-medium underline">Shop Now</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="bg-[#f6f1eb] py-16 px-6">
  <div class="max-w-5xl mx-auto text-center">
    <h2 class="text-3xl font-serif font-semibold text-gray-900 mb-10">What They Say</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow-sm text-left">
        <p class="italic text-sm text-gray-700 mb-4">“Scent yang aku cari selama ini. Nggak pasaran, dan tahan lama banget.”</p>
        <p class="text-sm font-semibold text-gray-900">– Dinda, Bandung</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-sm text-left">
        <p class="italic text-sm text-gray-700 mb-4">“Kemasannya cantik, aromanya mewah. Worth every penny.”</p>
        <p class="text-sm font-semibold text-gray-900">– Naya, Jakarta</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-sm text-left">
        <p class="italic text-sm text-gray-700 mb-4">“Suka banget sama ingredients-nya. Aromanya elegan tapi lembut.”</p>
        <p class="text-sm font-semibold text-gray-900">– Fika, Surabaya</p>
      </div>
    </div>
  </div>
</section>



@endsection