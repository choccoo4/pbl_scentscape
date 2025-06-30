@extends('layouts.app')

@section('title', 'Gifts - Scentscape')

@section('content')
<!-- Hero Section -->
<x-herosection
    background="{{ asset('images/hero-home.png') }}"
    title="Gifts"
    subtitle="Share the timeless beauty of fragrance with someone special." />

<section class="bg-[#f2ede4] py-10">
    <div class="max-w-screen-xl mx-auto px-2 xl:px-4">
        @if ($products->isEmpty())
        <div class="text-center text-gray-600 py-20">
            <h2 class="text-xl font-semibold mb-2">
                There are no special <span class="text-[#BFA6A0]">Gifts</span> available at the moment.
            </h2>
            <p class="text-sm">Feel free to explore other categories in the meantime!</p>
        </div>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-x-2 gap-y-4">
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

        {{-- Pagination --}}
        @if ($products->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $products->links('pagination::tailwind-custom') }}
        </div>
        @endif
        @endif
    </div>
</section>
@endsection