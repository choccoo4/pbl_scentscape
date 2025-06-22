@extends('layouts.seller')
@section('title', 'Dashboard - Scentscape')

@section('content')
<div class="mb-6 px-4 md:px-6 lg:px-10">
    <h1 class="text-3xl font-semibold text-[#414833] flex items-center gap-3">
        <i class="fa-solid fa-gauge"></i> Selamat datang di Dashboard
    </h1>
    <p class="text-[#9BAF9A] text-sm mt-1">Toko kamu terlihat wangi hari ini 🌿</p>
</div>

<!-- Ringkasan -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 px-4 md:px-6 lg:px-10">
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#9BAF9A] text-white">
            <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Total Penjualan Harian</p>
            <p class="text-lg font-semibold text-[#3E3A39]">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#BFA6A0] text-white">
            <i class="fa-solid fa-bag-shopping text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Pesanan Masuk</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $pesananMasuk }} Pesanan</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#D6C6B8] text-white">
            <i class="fa-solid fa-truck-fast text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Produk Terjual Harian</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $produkTerjual }} Produk</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#9BAF9A] text-white">
            <i class="fa-solid fa-box text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Total Stok Produk</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $totalStokProduk }} Produk</p>
        </div>
    </div>
</div>

<!-- Highlight aktivitas -->
<div class="bg-[#9BAF9A]/10 border-l-4 border-[#9BAF9A] text-[#414833] p-4 md:p-5 rounded-lg mb-6 mx-4 md:mx-6 lg:mx-10">
    <p class="text-sm">
        Hari ini kamu mendapatkan <span class="font-bold">{{ $pesananBaruHariIni }} pesanan baru</span> dan <span class="font-bold">{{ $produkTerkirimHariIni }} produk</span> dikirim ke pembeli. Tetap semangat! 🌟
    </p>
</div>

<!-- Placeholder Chart Section -->
<div class="bg-white rounded-xl shadow p-6 mt-6 max-w-4xl mx-auto">
    <p class="mb-4 font-semibold text-[#3E3A39] text-left">Statistik Penjualan Mingguan</p>
    <canvas id="salesChart" height="100"></canvas>
</div>
@endsection