@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="bg-[#F6F1EB] min-h-screen py-12 px-6">
    <div class="flex flex-col md:flex-row justify-center gap-6 max-w-4xl mx-auto">

        <!-- KIRI: Informasi Transaksi -->
        <div class="md:w-1/2 w-full bg-[#9BAF9A] text-white p-8 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">Informasi Transaksi</h2>
            <div class="space-y-4 text-sm">
                <div>
                    <p class="opacity-80">Nomor Invoice</p>
                    <p class="font-semibold">INV-SCENT-20250501-001</p>
                </div>
                <div>
                    <p class="opacity-80">Tanggal & Waktu</p>
                    <p class="font-semibold">01 Mei 2025 - 14:23 WIB</p>
                </div>
                <div>
                    <p class="opacity-80">Nama Pembeli</p>
                    <p class="font-semibold">Chocolatte</p>
                </div>
                <div>
                    <p class="opacity-80">Metode Pembayaran</p>
                    <p class="font-semibold">QRIS</p>
                </div>
                <div>
                    <p class="opacity-80">Status Pembayaran</p>
                    <span class="inline-block bg-yellow-200 text-yellow-800 font-semibold px-3 py-1 rounded-full text-xs">Menunggu Pembayaran</span>
                </div>
                <div>
                    <p class="opacity-80">Batas Waktu Pembayaran</p>
                    <p class="font-semibold">01 Mei 2025 - 15:23 WIB</p>
                </div>
                <div class="mt-6">
                    <form action="/upload-bukti" method="POST" enctype="multipart/form-data" class="space-y-3" x-data="{ fileName: '' }">
                        @csrf
                        <label class="block text-sm font-medium text-[#3E3A39]">Upload Bukti Pembayaran</label>

                        <!-- Input File (hidden) -->
                        <input
                            type="file"
                            name="bukti"
                            class="hidden"
                            id="upload-bukti"
                            x-on:change="fileName = $event.target.files[0].name"
                            required>

                        <!-- Custom button -->
                        <label for="upload-bukti" class="cursor-pointer inline-block bg-[#414833] text-white text-sm px-4 py-2 rounded hover:bg-[#BFA6A0] transition-colors">
                            Pilih File
                        </label>

                        <!-- Display filename -->
                        <span class="block text-sm text-[#3E3A39] italic" x-text="fileName ? fileName : 'Belum ada file dipilih'"></span>

                        <!-- Submit button -->
                        <button
                            type="submit"
                            class="block bg-[#414833] text-white px-5 py-2 rounded hover:bg-[#BFA6A0] transition-colors">
                            Upload Bukti
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <!-- KANAN: QR Code -->
        <div class="md:w-1/2 w-full bg-white p-8 rounded-lg shadow-lg flex flex-col items-center justify-center text-center space-y-4">
            <h2 class="text-2xl font-bold text-[#3E3A39]">Scentscape</h2>
            <p class="text-sm text-[#3E3A39]">NMID : ID123456781234944</p>

            <div class="bg-[#F6F1EB] p-4 rounded-lg border border-[#D6C6B8]">
                <img src="{{ asset('images/qr-scentscape.png') }}" alt="QR-code" class="h-60 w-60 object-contain">
            </div>

            <p class="text-[#3E3A39] text-base font-medium">Scan QR untuk melakukan pembayaran sebesar:</p>
            <p class="text-[#3E3A39] text-2xl font-bold">Rp 774.000</p>

            <a href="/home">
                <button class="mt-4 bg-[#BFA6A0] text-white px-6 py-2 rounded hover:bg-[#9BAF9A] transition-all">
                    Back to Home
                </button>
            </a>
        </div>
    </div>
</div>
@endsection