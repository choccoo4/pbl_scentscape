@extends('layouts.app')
@section('title', 'Cart - Scentscape')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<div class="min-h-screen bg-[#F6F1EB] py-10 px-6 md:px-20">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-semibold text-center text-[#3E3A39] mb-8">Your Cart</h1>

        <div x-data="cartRoot()" x-init="$nextTick(() => init.call($data))" x-ref="root" class="space-y-6">
            <p class="text-xl text-[#3E3A39] mb-4 font-medium">Select Products to Checkout</p>

            {{-- Jika keranjang kosong --}}
            @if (count($cartItems) === 0)
            <div class="bg-white text-center p-10 rounded-lg shadow-md">
                <p class="text-xl text-gray-600 mb-4">No products have been added to the cart.</p>
                <a href="{{ route('shop') }}" class="inline-block mt-2 px-6 py-2 bg-[#414833] text-white rounded hover:bg-[#8da48c] transition">
                    View Products
                </a>
            </div>
            @else
            {{-- Jika keranjang berisi item --}}
            @foreach ($cartItems as $index => $item)
            <div x-data="cartItem({{ $item['price'] }}, {{ $item['quantity'] }}, {{ $item['no_produk'] }}, {{ $item['stock'] }}, false)"
                x-ref="cartItem{{ $index }}"
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Kiri -->
                    <div class="flex items-center gap-4 w-full sm:w-1/2">
                        <input type="checkbox" class="form-checkbox text-[#9BAF9A]" :checked="selected" @change="toggleSelected($event.target.checked)" />
                        <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-md border border-[#D6C6B8]">
                        <div>
                            <p class="text-base font-semibold text-[#3E3A39]">{{ $item['name'] }}</p>
                            <p class="text-sm text-[#6B7280]">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="flex items-center justify-between gap-4 sm:gap-6 flex-wrap sm:flex-nowrap w-full sm:w-1/2">
                        <!-- Qty -->
                        <div class="flex items-center space-x-2">
                            <button @click="decrease" class="border border-[#9BAF9A] text-[#9BAF9A] px-2 py-1 rounded hover:bg-[#F6F1EB]">-</button>
                            <span class="text-base" x-text="quantity"></span>
                            <button @click="increase" class="border border-[#9BAF9A] text-[#9BAF9A] px-2 py-1 rounded hover:bg-[#F6F1EB]">+</button>
                        </div>

                        <!-- Hapus -->
                        <div x-data>
                            <form x-ref="form" action="{{ route('cart.remove', $item['no_produk']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    @click="Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'This item will be deleted from your cart.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#aaa',
                                        confirmButtonText: 'Yes, delete it',
                                        cancelButtonText: 'No, keep it',
                                        customClass: { popup: 'w-[90%] md:w-[400px]' },
                                    }).then((result) => {
                                        if (result.isConfirmed) $refs.form.submit()
                                    })"
                                    class="text-sm text-[#D6C6B8] hover:text-[#9BAF9A]">
                                    Remove
                                </button>
                            </form>
                        </div>

                        <!-- Total -->
                        <p class="text-base font-semibold text-[#3E3A39]">Rp <span x-text="total.toLocaleString('id-ID')"></span></p>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Total Checkout --}}
            <div class="flex flex-col sm:flex-row justify-between items-center bg-[#D6C6B8] p-6 rounded-lg shadow-lg mt-6 space-y-4 sm:space-y-0">
                <div class="text-center sm:text-left">
                    <p class="text-xl font-medium text-[#3E3A39]">
                        Total: <span class="font-semibold text-[#9BAF9A]">Rp <span x-text="selectedTotal.toLocaleString('id-ID')"></span></span>
                    </p>
                    <p class="text-sm text-[#3E3A39]">Shipping & taxes calculated at checkout</p>
                </div>
                <form method="POST" action="{{ route('checkout.page') }}" x-data>
                    @csrf
                    <input type="hidden" name="selected_items" :value="JSON.stringify(cartItems.filter(i => i.selected).map(i => ({ id: i.idProduk, qty: i.quantity })))">
                    <button type="submit" class="bg-[#414833] text-white px-8 py-3 text-lg font-medium hover:bg-[#00695C] transition-colors rounded-lg">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
            @endif

            {{-- Tagline --}}
            <div class="text-center mt-8 text-[#9BAF9A]">
                <p>"Every scent tells a story"</p>
            </div>
        </div>
    </div>
</div>
@endsection