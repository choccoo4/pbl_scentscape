@extends('layouts.app')

@section('title', 'Detail Produk - Scentscape')

@section('content')
<section class="bg-[#f4f0e9] min-h-screen py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        {{-- Gambar Produk --}}
        @php
        $images = $product->gambar ?? [];
        @endphp

        <div x-data='{
                current: 0,
                images: @json($images)
            }' class="flex flex-col items-center">
            <div class="relative w-[300px] aspect-square overflow-hidden rounded-2xl shadow-md">
                <img :src="'/storage/' + images[current]" alt="{{ $product->nama_produk }}"
                    class="object-cover w-full h-full transition-all duration-300">
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
            <h1 class="text-3xl font-bold text-center lg:text-left mb-2">
                {{ $product->nama_produk }}
            </h1>
            <p class="text-xl font-semibold text-[#9E7D60] text-center lg:text-left">
                Rp {{ number_format($product->harga, 0, ',', '.') }}
            </p>

            <div class="mt-4 flex flex-wrap gap-2 text-sm justify-center lg:justify-start">
                <span class="px-3 py-1 bg-[#9BAF9A] text-white rounded-full font-medium shadow-sm">
                    {{ $product->label_kategori }}
                </span>
                <span class="px-3 py-1 bg-[#D6C6B8] text-[#3E3A39] rounded-full font-medium shadow-sm">
                    {{ $product->volume }}
                </span>
                <span class="px-3 py-1 bg-[#BFA6A0] text-white rounded-full font-medium shadow-sm">
                    {{ $product->tipe_parfum }}
                </span>
            </div>

            <hr class="my-6 border-gray-300">

            <p class="leading-relaxed text-justify text-sm">
                {!! nl2br(e($product->deskripsi)) !!}
            </p>

            @if ($product->aroma->count())
            <div class="mt-6">
                <h3 class="font-semibold mb-2 text-[#3E3A39]">Nuansa Aroma:</h3>
                <div class="flex flex-wrap gap-3 items-center">
                    @foreach ($product->aroma as $index => $aroma)
                    <div class="relative">
                        <button
                            type="button"
                            data-tooltip-target="tooltip-aroma-detail-{{ $index }}"
                            data-tooltip-placement="top"
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
            <div class="mt-10" x-data="productDetail({{ $product->harga }}, {{ $product->stok }})">
                <div class="space-y-4">
                    <!-- Total Harga -->
                    <div class="text-lg font-semibold text-[#3E3A39]">
                        Total: Rp <span x-text="totalFormatted"></span>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('cart.add', $product->no_produk) }}" @submit="handleSubmit">
                        @csrf
                        <input type="hidden" name="quantity" :value="qty">

                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border rounded px-2 py-1 bg-white shadow-sm">
                                <button type="button" @click="decreaseQty()"
                                    class="px-3 text-lg font-bold text-gray-600 hover:text-[#9BAF9A] transition"
                                    :disabled="qty <= 1">-</button>
                                <input type="number" x-model.number="qty" min="1" :max="stock"
                                    class="w-12 text-center border-none focus:ring-0"
                                    @change="validateQty()">
                                <button type="button" @click="increaseQty()"
                                    class="px-3 text-lg font-bold text-gray-600 hover:text-[#9BAF9A] transition"
                                    :disabled="qty >= stock">+</button>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="submit"
                                class="bg-[#9BAF9A] hover:bg-[#88a488] text-white font-semibold px-8 py-3 rounded shadow transition w-full sm:w-auto"
                                :disabled="qty > stock || stock <= 0">
                                <span x-show="qty === 1">Tambah ke Keranjang</span>
                                <span x-show="qty > 1" x-text="'Tambah ' + qty + ' ke Keranjang'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-4 flex items-center justify-between text-sm">
                    <p class="text-gray-500">
                        Tersedia: <span class="font-semibold text-[#3E3A39]" x-text="stock"></span> item
                    </p>
                    <p class="text-orange-600" x-show="stock <= 5 && stock > 0">
                        Stok terbatas!
                    </p>
                    <p class="text-red-600 font-medium" x-show="stock <= 0">
                        Stok habis
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" 
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('error') }}
        </div>
    @endif
</section>

<script>
function productDetail(basePrice, maxStock) {
    return {
        qty: 1,
        basePrice: basePrice,
        stock: maxStock,

        get totalFormatted() {
            return (this.basePrice * this.qty).toLocaleString('id-ID');
        },

        increaseQty() {
            if (this.qty < this.stock) {
                this.qty++;
            }
        },

        decreaseQty() {
            if (this.qty > 1) {
                this.qty--;
            }
        },

        validateQty() {
            if (this.qty < 1) {
                this.qty = 1;
            } else if (this.qty > this.stock) {
                this.qty = this.stock;
            }
        },

        handleSubmit(event) {
            if (this.stock <= 0) {
                event.preventDefault();
                alert('Produk tidak tersedia!');
                return false;
            }

            if (this.qty > this.stock) {
                event.preventDefault();
                alert('Jumlah melebihi stok yang tersedia!');
                return false;
            }

            // Loading State
            event.target.querySelector('button[type="submit"]').innerHTML = 'Menambahkan...';
            event.target.querySelector('button[type="submit"]').disabled = true;
        }
    }
}
</script>
@endsection
