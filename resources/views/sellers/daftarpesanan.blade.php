@extends('layouts.seller')
@section('title', 'Daftar Pesanan - Scentscape')
@section('content')
<h1 class="text-2xl mb-4 flex items-center gap-2">
    <i class="fa-solid fa-clipboard-list mr-2"></i> Daftar Pesanan</h1>
    <hr class="mb-6 border-gray-400">

    <!-- Tab Status + Search -->
<div class="mb-4 flex flex-wrap items-end justify-between gap-4">
    <!-- Tab Status -->
    <div class="flex flex-wrap gap-2">
        @foreach (['Semua', 'Konfirmasi', 'Dikemas', 'Dikirim', 'Selesai'] as $tab)
        <button class="px-4 py-2 rounded-md font-medium text-sm 
            {{ request('status') === strtolower($tab) || ($tab === 'Semua' && !request('status')) ? 'bg-[#8B3E00] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            {{ $tab }}
        </button>
        @endforeach
    </div>

    <!-- Search Box -->
    <form action="{{ url()->current() }}" method="GET" class="flex-grow max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-white border border-gray-300 text-sm rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-brown-600" placeholder="Cari pesanan..." />
    </form>
</div>


    <!-- Tabel Pesanan -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-3 font-medium">No</th>
                    <th class="px-4 py-3 font-medium">Tanggal Pemesanan</th>
                    <th class="px-4 py-3 font-medium">ID Pesanan</th>
                    <th class="px-4 py-3 font-medium">Pembayaran</th>
                    <th class="px-4 py-3 font-medium">Total Belanja</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">03 Maret 2025</td>
                    <td class="px-4 py-3">03/09/6578ebZ</td>
                    <td class="px-4 py-3">Cash On Delivery</td>
                    <td class="px-4 py-3">Rp105.615</td>
                    <td class="px-4 py-3">Dikonfirmasi</td>
                    <td class="px-4 py-3">
                        <a href="#" class="bg-green-700 hover:bg-green-800 text-white text-xs px-3 py-1 rounded">Detail Transaksi</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">2</td>
                    <td class="px-4 py-3">04 Maret 2025</td>
                    <td class="px-4 py-3">03/09/egrj675sset</td>
                    <td class="px-4 py-3">Cash On Delivery</td>
                    <td class="px-4 py-3">Rp256.615</td>
                    <td class="px-4 py-3">Selesai</td>
                    <td class="px-4 py-3">
                        <a href="#" class="bg-green-700 hover:bg-green-800 text-white text-xs px-3 py-1 rounded">Detail Transaksi</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
