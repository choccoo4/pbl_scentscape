@extends('layouts.app')

@section('title', 'Shop - Scentscape')

@section('content')
<section class="bg-[#f2ede4] min-h-screen px-4 md:px-10 py-10" x-data>
    <h2 class="text-center font-playfair font-semibold text-lg text-gray-800 mb-6">Products</h2>

    {{-- Filter Header --}}
    <form method="GET" action="{{ route('shop') }}" class="mb-4">
        @php
            $filterClass = 'border border-[#D6C6B8] bg-white/30 backdrop-blur-md rounded-full px-6 py-1 text-sm shadow-sm hover:shadow-md transition-all';
        @endphp

        <div class="flex flex-wrap items-center justify-between text-[15px] text-[#5E4530] font-[500] gap-4">
            <div class="flex flex-wrap items-center gap-4">
                <span class="tracking-wider">Filter:</span>

                {{-- Filter Aroma --}}
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open" class="{{ $filterClass }} flex items-center gap-1">
                        Aroma <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute left-0 mt-2 bg-white border rounded shadow w-40 z-10">
                        <ul class="text-sm">
                            <li><a href="{{ route('shop', array_merge(request()->except('aroma'), ['aroma' => ''])) }}" class="block px-3 py-2 hover:bg-gray-100">Semua</a></li>
                            @foreach ($aromas as $aroma)
                                <li>
                                    <a href="{{ route('shop', array_merge(request()->except('aroma'), ['aroma' => $aroma->nama])) }}"
                                       class="block px-3 py-2 hover:bg-gray-100 {{ request('aroma') == $aroma->nama ? 'font-semibold' : '' }}">
                                        {{ $aroma->nama }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Filter Gender --}}
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open" class="{{ $filterClass }} flex items-center gap-1">
                        Gender <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute left-0 mt-2 bg-white border rounded shadow w-40 z-10">
                        <ul class="text-sm">
                            <li><a href="{{ route('shop', array_merge(request()->except('gender'), ['gender' => ''])) }}" class="block px-3 py-2 hover:bg-gray-100">Semua</a></li>
                            @foreach (['unisex', 'for him', 'for her', 'gifts'] as $gender)
                                <li>
                                    <a href="{{ route('shop', array_merge(request()->except('gender'), ['gender' => $gender])) }}"
                                       class="block px-3 py-2 hover:bg-gray-100 {{ request('gender') == $gender ? 'font-semibold' : '' }}">
                                        {{ ucfirst($gender) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Filter Tipe --}}
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open" class="{{ $filterClass }} flex items-center gap-1">
                        Tipe <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute left-0 mt-2 bg-white border rounded shadow w-48 z-10">
                        <ul class="text-sm">
                            <li><a href="{{ route('shop', array_merge(request()->except('type'), ['type' => ''])) }}" class="block px-3 py-2 hover:bg-gray-100">Semua</a></li>
                            @foreach ([
                                'EDP' => 'Eau De Parfum',
                                'EDT' => 'Eau De Toilette',
                                'BodyMist' => 'Body Mist',
                                'Cologne' => 'Cologne',
                                'ParfumOil' => 'Parfum Oil',
                                'SolidParfum' => 'Solid Parfum'
                            ] as $type => $label)
                                <li>
                                    <a href="{{ route('shop', array_merge(request()->except('type'), ['type' => $type])) }}"
                                       class="block px-3 py-2 hover:bg-gray-100 {{ request('type') == $type ? 'font-semibold' : '' }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Filter Volume --}}
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open" class="{{ $filterClass }} flex items-center gap-1">
                        Volume <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute left-0 mt-2 bg-white border rounded shadow w-48 z-10">
                        <ul class="text-sm">
                            <li><a href="{{ route('shop', array_merge(request()->except('volume'), ['volume' => ''])) }}" class="block px-3 py-2 hover:bg-gray-100">Semua</a></li>
                            <li><a href="{{ route('shop', array_merge(request()->except('volume'), ['volume' => 'small'])) }}" class="block px-3 py-2 hover:bg-gray-100 {{ request('volume') == 'small' ? 'font-semibold' : '' }}">Kecil (&lt;30ml)</a></li>
                            <li><a href="{{ route('shop', array_merge(request()->except('volume'), ['volume' => 'medium'])) }}" class="block px-3 py-2 hover:bg-gray-100 {{ request('volume') == 'medium' ? 'font-semibold' : '' }}">Sedang (30–60ml)</a></li>
                            <li><a href="{{ route('shop', array_merge(request()->except('volume'), ['volume' => 'large'])) }}" class="block px-3 py-2 hover:bg-gray-100 {{ request('volume') == 'large' ? 'font-semibold' : '' }}">Besar (&gt;60ml)</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Sort --}}
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="tracking-wider">Sort by:</span>
                    <div x-data="{ open: false }" class="relative">
                        <button type="button" @click="open = !open" class="{{ $filterClass }} flex items-center gap-1">
                            {{ match(request('sort')) {
                                'price_asc' => 'Harga Termurah',
                                'price_desc' => 'Harga Termahal',
                                'name_asc' => 'Nama A-Z',
                                default => 'Terbaru'
                            } }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 bg-white border rounded shadow w-48 z-10">
                            <ul class="text-sm">
                                <li><a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => ''])) }}" class="block px-3 py-2 hover:bg-gray-100">Terbaru</a></li>
                                <li><a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'Harga Terendah'])) }}" class="block px-3 py-2 hover:bg-gray-100">Harga Termurah</a></li>
                                <li><a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'Harga Tertinggi'])) }}" class="block px-3 py-2 hover:bg-gray-100">Harga Termahal</a></li>
                                <li><a href="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'Nama'])) }}" class="block px-3 py-2 hover:bg-gray-100">Nama A-Z</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-sm tracking-wide">
                    {{ $products->total() }} produk
                </div>
            </div>
        </div>
    </form>

    {{-- Reset Filter --}}
    @if(request()->hasAny(['aroma', 'gender', 'type', 'volume', 'sort']))
        <div class="mb-6 text-sm text-[#5E4530] flex flex-wrap items-center gap-2">
            @foreach(['aroma', 'gender', 'type', 'volume', 'sort'] as $filter)
                @if(request($filter))
                    <a href="{{ route('shop', request()->except($filter)) }}"
                       class="bg-[#D6C6B8] px-3 py-1 rounded-full">
                        {{ ucfirst($filter) }}: {{ request($filter) }} ✕
                    </a>
                @endif
            @endforeach
            <a href="{{ route('shop') }}" class="ml-3 underline text-black text-sm">Reset</a>
        </div>
    @endif

    {{-- Produk --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-x-2 gap-y-4 px-2 xl:px-4">
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

    {{-- Pagination --}}
    @if ($products->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $products->links('pagination::tailwind-custom') }}
        </div>
    @endif

</section>
@endsection
