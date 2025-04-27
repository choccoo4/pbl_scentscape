@extends('layouts.penjual')

@section('content')
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<h1 class="text-2xl mb-4 flex items-center gap-2 ">
<i class="fa-solid fa-gauge"></i>Dashboard</h1>
<hr class="mb-6 border-gray-400">

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  <div class="bg-white shadow p-4 rounded flex justify-between items-center">
    <div>
      <p class="text-sm text-gray-500">Total Penjualan</p>
      <p class="text-lg">Rp 2.500.000</p>
    </div>
    <span class="text-2xl">
    <i class="fa-solid fa-hand-holding-dollar" style="color: #000000;"></i>
    </span>
  </div>

  <div class="bg-white shadow p-4 rounded flex justify-between items-center">
    <div>
      <p class="text-sm text-gray-500">Pesanan Masuk</p>
      <p class="text-lg">3 Pesanan</p>
    </div>
    <span class="text-2xl">
    <i class="fa-solid fa-bag-shopping" style="color: #000000;"></i>
    </span>
  </div>

  <div class="bg-white shadow p-4 rounded flex justify-between items-center">
    <div>
      <p class="text-sm text-gray-500">Produk Terjual</p>
      <p class="text-lg">15 Produk</p>
    </div>
    <span class="text-2xl">
    <i class="fa-solid fa-truck-fast" style="color: #000000;"></i>
    </span>
  </div>

  <div class="bg-white shadow p-4 rounded flex justify-between items-center">
    <div>
      <p class="text-sm text-gray-500">Total Stok Produk</p>
      <p class="text-lg">140 Produk</p>
    </div>
    <span class="text-2xl">
    <i class="fa-solid fa-box" style="color: #000000;"></i>
    </span>
  </div>
</div>
@endsection
