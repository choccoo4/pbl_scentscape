@extends('layouts.seller')
@section('title', 'Rekapitulasi Penjualan Harian - Scentscape')

@section('content')

<div class="bg-[#f6f1eb] shadow rounded-xl p-6">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold flex items-center gap-3 text-[#3e3a39]">
            <i class="fa-solid fa-receipt text-[#414833]"></i> Rekapitulasi Penjualan Harian
        </h1>

        <!-- Search bar -->
        <div class="mb-0">
            <input type="text" placeholder="Cari produk..." class="border border-[#bfa6a0] rounded-full px-4 py-2 text-sm w-75 focus:outline-none focus:ring-2 focus:ring-[#9baf9a]">
        </div>
    </div>

    <hr class="mb-6 border-[#d6c6b8]">

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-[#d6c6b8]">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-[#9baf9a] text-white">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Barang</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">QTY</th>
                    <th class="px-4 py-3">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white text-[#3e3a39]">
                <tr class="hover:bg-[#f6f1eb] transition">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Parfum Vanilla Mist</td>
                    <td class="px-4 py-3">Rp. 150.000</td>
                    <td class="px-4 py-3">2</td>
                    <td class="px-4 py-3">Rp. 300.000</td>
                </tr>
                <tr class="hover:bg-[#f6f1eb] transition">
                    <td class="px-4 py-3">2</td>
                    <td class="px-4 py-3">Parfum Citrus Bloom</td>
                    <td class="px-4 py-3">Rp. 120.000</td>
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Rp. 120.000</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="flex justify-end mt-6">
        <div class="text-lg font-semibold text-[#414833]">
            Grand Total: <span class="text-[#bfa6a0]">Rp. 420.000</span>
        </div>
    </div>

    <!-- Action -->
    <div class="mt-6 text-right">
        <button class="bg-[#414833] hover:bg-[#3e3a39] text-white px-6 py-2 rounded-full shadow transition">
            <i class="fa-solid fa-print mr-2"></i> Print
        </button>
    </div>
</div>
@endsection