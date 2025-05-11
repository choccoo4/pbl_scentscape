@extends('layouts.app')

@section('title', 'Home - Scentscape')

@section('content')
<!-- Hero Section -->
<x-herosection
  background="{{ asset('images/hero-home.png') }}"
  title="Scents that Speak Softly"
  subtitle="A curated selection of fragrances with feminine nuances,<br>made for every person, every moment." />
<!-- Latest Releases -->
<section class="bg-[#f2ede4] py-10">
  <div class="max-w-screen-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-lg md:text-xl font-semibold text-gray-800 font-serif pl-5">Latest releases</h2>
      <a href="{{ route('shop')}}" class="text-sm text-gray-600 hover:text-gray-800 font-medium font-serif pr-5">SEE MORE</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-x-2 gap-y-4 px-2 xl:px-4">
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


<section class="bg-[#f2ede4] py-16 px-6 text-center">
  <h2 class="text-3xl font-semibold text-gray-900 mb-3 font-serif">Ingredients</h2>
  <p class="text-gray-600 max-w-xl mx-auto mb-8">
    Check the characteristics of more than 100 ingredients and discover the perfumes in which they are present.
  </p>

  <div class="flex justify-center flex-wrap gap-6 mb-8">
    @php
    $ingredients = [
    ['name' => 'Musk', 'img' => 'musk.jpg'],
    ['name' => 'Bergamot', 'img' => 'bergamot.jpeg'],
    ['name' => 'Amber', 'img' => 'amber.jpeg'],
    ['name' => 'Patchouli', 'img' => 'patchouli.jpg'],
    ['name' => 'Sandalwood', 'img' => 'sandalwood.jpeg'],
    ['name' => 'Vanilla', 'img' => 'vanilla.jpg'],
    ['name' => 'Jasmine', 'img' => 'jasmine.jpeg'],
    ['name' => 'Cedarwood', 'img' => 'cedarwood.jpg'],
    ];
    @endphp

    @foreach ($ingredients as $item)
    <div class="flex flex-col items-center w-20">
      <div class="w-20 h-20 rounded-full overflow-hidden border border-gray-200">
        <img src="{{ asset('images/ingredients/' . $item['img']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover" />
      </div>
      <p class="mt-2 text-sm text-gray-800 font-medium">{{ $item['name'] }}</p>
    </div>
    @endforeach
  </div>

  <!--<a href="#" class="text-sm text-black underline hover:text-gray-700 transition-all duration-200">
    EXPLORE CATALOGUE
  </a>-->
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
      <div class="flex flex-col md:flex-row items-center bg-white rounded-lg overflow-hidden shadow-md">
        <img src="{{ asset('images/products/image2-1.jpg') }}" alt="Ethereal" class="w-full md:w-1/2 h-60 object-cover" />
        <div class="p-6 text-left">
          <h3 class="text-lg font-serif font-semibold text-gray-900">Ethereal</h3>
          <p class="text-gray-700 text-sm mt-2 mb-4">Soft yet striking, this fragrance whispers elegance for everyday moments.</p>
          <a href="#" class="text-[#3e3a39] font-medium underline">Shop Now</a>
        </div>
      </div>
      <div class="flex flex-col md:flex-row items-center bg-white rounded-lg overflow-hidden shadow-md">
        <img src="{{ asset('images/products/image10 (3).jpg') }}" alt="Victoria's Secret" class="w-full md:w-1/2 h-60 object-cover" />
        <div class="p-6 text-left">
          <h3 class="text-lg font-serif font-semibold text-gray-900">Victoria's Secret</h3>
          <p class="text-gray-700 text-sm mt-2 mb-4">An artistic blend of rosewood and vanilla, this scent is bold and poetic.</p>
          <a href="#" class="text-[#3e3a39] font-medium underline">Shop Now</a>
        </div>
      </div>
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