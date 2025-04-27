@extends('layouts.app')

@section('title', 'Transaksi_Penjualan')

@section('content')
<div class="bg-[#FDF6EF] min-h-screen py-12 px-6">
    <div class="flex justify-center gap-6">

        <!-- KIRI: Informasi Transaksi dengan background hijau -->
        <div class="w-76 bg-teal-900 text-white p-10 flex flex-col justify-center">
            <p class="mt-[-10px] mb-8">Nomor Invoice : <br>001</p>
            <p class="mb-8">Tanggal Transaksi : <br>12–June–2025</p>
            <p class="mb-8 text-lg">Total Pembayaran : <br> 
                <span class="text-2xl font-bold">Rp 774.000</span>
            </p>
        </div>

        <!-- KANAN: QR Code dalam box putih -->
        <div class="w-76 bg-white p-8 shadow-lg flex flex-col items-center text-center">
            <h2 class="text-xl font-semibold mb-2">Scentscape</h2>
            <p class="text-sm mb-4">NMID : ID123456781234944</p>
            <img src="{{ asset('images/qr-scentscape.png') }}" alt="QR-code" class="mb-4 h-50 w-40">
            <a href="/home">
                <button class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Back</button>
            </a>
        </div>

    </div>
</div>
@endsection