@extends('layouts.app')
@section('title', 'Checkout - Scentscape')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-10 px-6 md:px-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Form Pengiriman -->
        <div>
            <h2 class="text-2xl font-semibold mb-6">Delivery</h2>
            <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex gap-4">
                    <input name="full_name" type="text" placeholder="Full Name"
                        value="{{ old('full_name', $pembeli->pengguna->nama ?? '') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <input name="address" type="text" placeholder="Address"
                    value="{{ old('address', $parsedAlamat['address'] ?? '') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
                <input name="city" type="text" placeholder="City"
                    value="{{ old('city', $parsedAlamat['city'] ?? '') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
                <div class="flex gap-4">
                    <input name="province" type="text" placeholder="Province"
                        value="{{ old('province', $parsedAlamat['province'] ?? '') }}"
                        class="w-1/2 border border-gray-300 rounded px-3 py-2">
                    <input name="postal_code" type="text" placeholder="Postal code"
                        value="{{ old('postal_code', $parsedAlamat['postal_code'] ?? '') }}"
                        class="w-1/2 border border-gray-300 rounded px-3 py-2">
                </div>
                <input name="phone" type="text" placeholder="Phone"
                    value="{{ old('phone', $pembeli->no_telp ?? '') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
                <button type="submit" class="bg-[#8da48c] text-white px-6 py-2 rounded mt-4 inline-block text-center">Pay Now</button>
            </form>
        </div>

        <!-- Ringkasan Pembelian -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
            <div class="space-y-4">
                @foreach ($produkList as $produk)
                <div class="flex items-center gap-4 hover:bg-gray-50 p-2 rounded transition">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $produk->gambar_utama) }}" alt="{{ $produk->nama_produk }}" class="w-16 h-16 object-cover rounded">
                        <span class="absolute -top-2 -right-2 bg-[#004D45] text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">{{ $produk->qty }}</span>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <p class="font-medium">{{ $produk->nama_produk }}</p>
                        <p class="text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 border-t pt-8 space-y-2 text-right">
                <p>Subtotal: <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></p>
                <p>Shipping: <span class="font-medium">Rp {{ number_format($shipping, 0, ',', '.') }}</span></p>
                <p class="text-lg font-bold text-[#004D45]">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>
        </div>

    </div>
</div>
@endsection