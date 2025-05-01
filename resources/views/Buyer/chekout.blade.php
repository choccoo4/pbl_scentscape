@extends('layouts.app')
@section('title', 'Checkout - Scentscape')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-10 px-6 md:px-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Form Pengiriman -->
        <div>
            <h2 class="text-2xl font-semibold mb-6">Delivery</h2>
            <form class="space-y-4">
                <div class="flex gap-4">
                    <input type="text" placeholder="First name" class="w-1/2 border border-gray-300 rounded px-3 py-2">
                    <input type="text" placeholder="Last name" class="w-1/2 border border-gray-300 rounded px-3 py-2">
                </div>
                <input type="text" placeholder="Address" class="w-full border border-gray-300 rounded px-3 py-2">
                <input type="text" placeholder="City" class="w-full border border-gray-300 rounded px-3 py-2">
                <div class="flex gap-4">
                    <input type="text" placeholder="Province" class="w-1/2 border border-gray-300 rounded px-3 py-2">
                    <input type="text" placeholder="Postal code" class="w-1/2 border border-gray-300 rounded px-3 py-2">
                </div>
                <input type="text" placeholder="Phone" class="w-full border border-gray-300 rounded px-3 py-2">

                <a href="/transaksi" class="bg-[#8da48c] text-white px-6 py-2 rounded mt-4 inline-block text-center">Pay Now</a>
            </form>
        </div>

        <!-- Ringkasan Pembelian -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
            <div class="space-y-4">
                <div class="flex items-center gap-4 hover:bg-gray-50 p-2 rounded transition">
                    <div class="relative">
                        <img src="{{ asset('images/products/image6-1.png') }}" alt="Almalika" class="w-16 h-16 object-cover rounded">
                        <span class="absolute -top-2 -right-2 bg-[#004D45] text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">1</span>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <p class="font-medium">Almalika</p>
                        <p class="text-sm">Rp 401.000</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 hover:bg-gray-50 p-2 rounded transition">
                    <div class="relative">
                        <img src="{{ asset('images/products/image7-1.png') }}" alt="Scent Designer Kit" class="w-16 h-16 object-cover rounded">
                        <span class="absolute -top-2 -right-2 bg-[#004D45] text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">1</span>
                    </div>
                    <div class="flex justify-between items-center w-full">
                    <p class="font-medium">Scent Designer Kit</p>
                    <p class="text-sm">Rp 341.000</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 border-t pt-8 space-y-2 text-right">
                <p>Subtotal: <span class="font-medium">Rp 742.000</span></p>
                <p>Shipping: <span class="font-medium">Rp 32.000</span></p>
                <p class="text-lg font-bold text-[#004D45]">Total: Rp 774.000</p>
            </div>
        </div>

    </div>
</div>
@endsection