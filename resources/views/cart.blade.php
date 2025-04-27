@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-10 px-6">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-semibold mb-8 text-center">Cart</h1>
        
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Product</th>
                    <th class="py-2">Product</th>
                    <th class="py-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Product 1 -->
                <tr class="border-b py-4">
                    <td class="py-4 flex items-center space-x-4">
                        <img src="{{ asset('images/products/image6-1.png') }}" alt="Almalika" class="w-16 h-16 object-cover rounded">
                        <div>
                            <p class="font-medium">Almalika</p>
                            <p class="text-gray-600">Rp 401.000</p>
                        </div>
                    </td>
                    <td class="py-4">
                        <div class="flex items-center space-x-2">
                            <button class="border px-2">-</button>
                            <span>1</span>
                            <button class="border px-2">+</button>
                        </div>
                        <a href="#" class="block text-sm text-gray-500 mt-1 underline">Remove</a>
                    </td>
                    <td class="py-4 text-right">Rp 401.000</td>
                </tr>

                <!-- Product 2 -->
                <tr class="border-b py-4">
                    <td class="py-4 flex items-center space-x-4">
                        <img src="{{ asset('images/products/image7-1.png') }}" alt="Scent Designer Kit" class="w-16 h-16 object-cover rounded">
                        <div>
                            <p class="font-medium">Scent Designer Kit</p>
                            <p class="text-gray-600">Rp 341.000</p>
                        </div>
                    </td>
                    <td class="py-4">
                        <div class="flex items-center space-x-2">
                            <button class="border px-2">-</button>
                            <span>1</span>
                            <button class="border px-2">+</button>
                        </div>
                        <a href="#" class="block text-sm text-gray-500 mt-1 underline">Remove</a>
                    </td>
                    <td class="py-4 text-right">Rp 341.000</td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="mt-6 text-right">
            <p class="text-base">Total: <span class="font-semibold">Rp 742.000</span></p>
            <p class="text-sm text-gray-600">Shipping & taxes calculated at checkout</p>
        </div>

        <!-- Checkout Button -->
        <div class="text-right mt-4">
            <a href="/checkout" class="bg-[#004D40] text-white px-6 py-2 text-sm font-medium hover:bg-[#00695C]">CHECKOUT</a>
        </div>
    </div>
</div>
@endsection
