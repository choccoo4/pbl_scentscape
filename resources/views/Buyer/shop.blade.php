@extends('layouts.app')

@section('title', 'Shop - Scentscape')

@section('content')
<section class="bg-[#f2ede4] min-h-screen px-4 md:px-10 py-10">
    {{-- Judul --}}
    <h2 class="text-center font-playfair font-semibold text-lg text-gray-800 mb-4">Products</h2>

    {{-- Filter Section (5 Kolom Sejajar) --}}
    <div class="grid grid-cols-5 gap-0 border-t border-b border-gray-500/30 text-sm text-gray-700 py-3 text-center">
        
        {{-- Filter Aroma --}}
        <div x-data="{ open: false }" class="relative border-l border-gray-300 first:border-l-0">
            <div @click="open = !open" class="cursor-pointer font-semibold">Aroma</div>
            <div x-show="open" x-cloak @click.away="open = false"
                 class="absolute inset-x-0 md:left-1/2 md:-translate-x-1/2 mt-2 w-44 mx-auto bg-white border shadow rounded-md z-50 text-left p-2 space-y-1">
                @foreach ($aromas as $aroma)
                    <a href="{{ route('shop', ['categories[]' => $aroma->nama]) }}"
                       class="block px-2 py-1 hover:bg-gray-100 rounded">{{ $aroma->nama }}</a>
                @endforeach
            </div>
        </div>

        {{-- Filter Gender --}}
        <div x-data="{ open: false }" class="relative border-l border-gray-300">
            <div @click="open = !open" class="cursor-pointer font-semibold">Gender</div>
            <div x-show="open" x-cloak @click.away="open = false"
                 class="absolute inset-x-0 md:left-1/2 md:-translate-x-1/2 mt-2 w-44 mx-auto bg-white border shadow rounded-md z-50 text-left p-2">
                <a href="{{ route('shop', ['gender' => 'unisex']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Unisex</a>
                <a href="{{ route('shop', ['gender' => 'for him']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">For Him</a>
                <a href="{{ route('shop', ['gender' => 'for her']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">For Her</a>
                <a href="{{ route('shop', ['gender' => 'gifts']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Gifts</a>
            </div>
        </div>

        {{-- Filter Tipe --}}
        <div x-data="{ open: false }" class="relative border-l border-gray-300">
            <div @click="open = !open" class="cursor-pointer font-semibold">Tipe</div>
            <div x-show="open" x-cloak @click.away="open = false"
                 class="absolute inset-x-0 md:left-1/2 md:-translate-x-1/2 mt-2 w-44 mx-auto bg-white border shadow rounded-md z-50 text-left p-2 space-y-1">
                <a href="{{ route('shop', ['type' => 'EDP']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Eau De Parfum (EDP)</a>
                <a href="{{ route('shop', ['type' => 'EDT']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Eau De Toilette (EDT)</a>
                <a href="{{ route('shop', ['type' => 'BodyMist']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Body Mist</a>
                <a href="{{ route('shop', ['type' => 'Cologne']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Cologne</a>
                <a href="{{ route('shop', ['type' => 'ParfumOil']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Parfum Oil</a>
                <a href="{{ route('shop', ['type' => 'SolidParfum']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Solid Perfume</a>
            </div>
        </div>

        {{-- Filter Volume --}}
        <div x-data="{ open: false }" class="relative border-l border-gray-300">
            <div @click="open = !open" class="cursor-pointer font-semibold">Volume</div>
            <div x-show="open" x-cloak @click.away="open = false"
                 class="absolute inset-x-0 md:left-1/2 md:-translate-x-1/2 mt-2 w-44 mx-auto bg-white border shadow rounded-md z-50 text-left p-2 space-y-1">
                <a href="{{ route('shop', ['volume' => 'small']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Small (&lt;30ml)</a>
                <a href="{{ route('shop', ['volume' => 'medium']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Medium (30–60ml)</a>
                <a href="{{ route('shop', ['volume' => 'large']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Large (&gt;60ml)</a>
            </div>
        </div>

        {{-- Sort --}}
        <div x-data="{ open: false }" class="relative border-l border-gray-300">
            <div @click="open = !open" class="cursor-pointer font-semibold">Sort</div>
            <div x-show="open" x-cloak @click.away="open = false"
                 class="absolute inset-x-0 md:left-1/2 md:-translate-x-1/2 mt-2 w-44 mx-auto bg-white border shadow rounded-md z-50 text-left p-2 space-y-1">
                <a href="{{ route('shop', ['sort' => 'price_asc']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Price: Low to High</a>
                <a href="{{ route('shop', ['sort' => 'price_desc']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Price: High to Low</a>
                <a href="{{ route('shop', ['sort' => 'newest']) }}"
                   class="block px-2 py-1 hover:bg-gray-100 rounded">Newest</a>
            </div>
        </div>
    </div>

    {{-- Pencarian --}}
    @if(request('q'))
        <p class="text-center text-sm text-gray-600 my-4">
            Menampilkan hasil pencarian untuk: <strong>{{ request('q') }}</strong>
        </p>
    @endif

    {{-- Produk --}}
    <div class="pt-5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-x-2 gap-y-4 px-2 xl:px-4">
        @forelse ($products as $product)
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
        @empty
            <p class="text-center col-span-full text-gray-500">Tidak ada produk ditemukan.</p>
        @endforelse
    </div>
</section>
@endsection
