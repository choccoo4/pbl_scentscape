@extends('layouts.app')

@section('title', 'Detail Produk - Scentscape')

@section('content')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<section class="bg-[#f4f0e9] min-h-screen py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        {{-- Gambar Produk --}}
        @php $images = $product->gambar ?? []; @endphp

        <div x-data='{
                current: 0,
                images: @json($images)
            }' class="flex flex-col items-center">
            <div class="relative w-[300px] aspect-square overflow-hidden rounded-2xl shadow-md">
                <img :src="'/storage/' + images[current]" alt="{{ $product->nama_produk }}"
                    class="object-cover w-full h-full transition-all duration-300">

                {{-- SOLD OUT badge --}}
                @if ($product->stok <= 0)
                    <div class="absolute top-3 right-3 z-10">
                    <span class="bg-[#BFA6A0] text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg uppercase tracking-wide">
                        Sold Out
                    </span>
            </div>
            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-0 rounded-2xl"></div>
            @endif

            <button @click="current = (current - 1 + images.length) % images.length"
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-white/70 p-2 rounded-full shadow-md text-xl">
                ‹
            </button>
            <button @click="current = (current + 1) % images.length"
                class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/70 p-2 rounded-full shadow-md text-xl">
                ›
            </button>
        </div>

        <div class="flex mt-4 space-x-2">
            <template x-for="(img, index) in images" :key="index">
                <img :src="'/storage/' + img" @click="current = index"
                    :class="current === index ? 'ring-2 ring-[#9BAF9A]' : ''"
                    class="w-16 h-16 object-cover rounded-lg cursor-pointer transition-all duration-300 shadow">
            </template>
        </div>
    </div>

    {{-- Detail Produk --}}
    <div class="text-[#3E3A39] px-4 sm:px-20 md:px-20 lg:px-0">
        <h1 class="text-3xl font-bold text-center lg:text-left mb-2">{{ $product->nama_produk }}</h1>
        <p class="text-xl font-semibold text-[#9E7D60] text-center lg:text-left">
            Rp {{ number_format($product->harga, 0, ',', '.') }}
        </p>

        <div class="mt-4 flex flex-wrap gap-2 text-sm justify-center lg:justify-start">
            <span class="px-3 py-1 bg-[#9BAF9A] text-white rounded-full font-medium shadow-sm">{{ $product->label_kategori }}</span>
            <span class="px-3 py-1 bg-[#D6C6B8] text-[#3E3A39] rounded-full font-medium shadow-sm">{{ $product->volume }}</span>
            <span class="px-3 py-1 bg-[#BFA6A0] text-white rounded-full font-medium shadow-sm">{{ $product->tipe_parfum }}</span>
        </div>

        <hr class="my-6 border-gray-300">
        <p class="leading-relaxed text-justify text-sm">{!! nl2br(e($product->deskripsi)) !!}</p>

        @if ($product->aroma->count())
        <div class="mt-6">
            <h3 class="font-semibold mb-2 text-[#3E3A39]">Fragrance Notes:</h3>
            <div class="flex flex-wrap gap-3 items-center">
                @foreach ($product->aroma as $aroma)
                <div class="relative">
                    <button type="button"
                        class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg shadow-sm border border-gray-200 text-[#3E3A39] hover:text-[#9BAF9A] transition text-sm">
                        <i class="ph {{ $aroma->aromaKategori?->icon ?? 'ph-flower' }} text-xl text-[#9BAF9A]"></i>
                        <span>{{ $aroma->nama }}</span>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Add to Cart Form --}}
        <div class="mt-10" x-data="{
                qty: 1,
                price: {{ $product->harga }},
                stock: {{ $product->stok }},
                get total() { return this.qty * this.price },
                get totalFormatted() {
                    return new Intl.NumberFormat('id-ID').format(this.total);
                },
                increaseQty() { if (this.qty < this.stock) this.qty++ },
                decreaseQty() { if (this.qty > 1) this.qty-- },
                validateQty() {
                    if (this.qty < 1) this.qty = 1;
                    if (this.qty > this.stock) this.qty = this.stock;
                }
            }">
            <div class="space-y-4">
                <div class="text-lg font-semibold text-[#3E3A39]">
                    Total: Rp <span x-text="totalFormatted"></span>
                </div>

                <form id="add-to-cart-form" method="POST" action="{{ route('cart.add', $product->no_produk) }}">
                    @csrf
                    <input type="hidden" name="quantity" :value="qty">

                    <div class="flex flex-col sm:flex-row gap-4 items-center">
                        <div class="flex items-center border rounded px-2 py-1 bg-white shadow-sm">
                            <button type="button" @click="decreaseQty()"
                                class="px-3 text-lg font-bold text-gray-600 hover:text-[#9BAF9A] transition"
                                :disabled="qty <= 1 || stock <= 0">-</button>
                            <input type="number" x-model.number="qty" min="1" :max="stock"
                                class="w-12 text-center border-none focus:ring-0"
                                @change="validateQty()" :disabled="stock <= 0">
                            <button type="button" @click="increaseQty()"
                                class="px-3 text-lg font-bold text-gray-600 hover:text-[#9BAF9A] transition"
                                :disabled="qty >= stock || stock <= 0">+</button>
                        </div>

                        @if ($product->stok > 0)
                        <button type="submit" id="add-to-cart-button"
                            class="bg-[#9BAF9A] hover:bg-[#88a488] text-white font-semibold px-8 py-3 rounded shadow transition w-full sm:w-auto">
                            <span x-show="qty === 1">Add to Cart</span>
                            <span x-show="qty > 1" x-text="'Add ' + qty + ' to Cart'"></span>
                        </button>
                        @else
                        <button type="button" id="out-of-stock-button"
                            class="bg-gray-400 text-white font-semibold px-8 py-3 rounded shadow cursor-not-allowed w-full sm:w-auto">
                            Out of Stock
                        </button>
                        @endif
                    </div>
                </form>
            </div>

            <div class="mt-4 flex items-center justify-between text-sm">
                <p class="text-gray-500">
                    Available: <span class="font-semibold text-[#3E3A39]" x-text="stock"></span> items
                </p>
                <p class="text-orange-600" x-show="stock <= 5 && stock > 0">Only a Few Left!</p>
                <p class="text-red-600 font-medium" x-show="stock <= 0">Out of Stock</p>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection