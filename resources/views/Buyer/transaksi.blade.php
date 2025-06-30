@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="bg-[#F6F1EB] min-h-screen py-12 px-6">
    <div class="flex flex-col md:flex-row justify-center gap-6 max-w-4xl mx-auto">

        <!-- LEFT: Transaction Info -->
        <div class="md:w-1/2 w-full bg-[#9BAF9A] text-white p-8 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">Transaction Details</h2>
            <div class="space-y-4 text-sm">
                <div>
                    <p class="opacity-80">Invoice Number</p>
                    <p class="font-semibold">{{ $pesanan->nomor_pesanan }}</p>
                </div>
                <div>
                    <p class="opacity-80">Date & Time</p>
                    <p class="font-semibold">{{ $pesanan->waktu_pemesanan->format('d M Y - H:i') }}</p>
                </div>
                <div>
                    <p class="opacity-80">Buyer Name</p>
                    <p class="font-semibold">{{ $pesanan->pengguna->nama ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="opacity-80">Payment Method</p>
                    <p class="font-semibold">QRIS</p>
                </div>
                <div>
                    <p class="opacity-80">Payment Status</p>

                    @if ($pesanan->status === 'Menunggu Pembayaran')
                    <span class="inline-block bg-yellow-200 text-yellow-800 font-semibold px-3 py-1 rounded-full text-xs">Waiting for Payment</span>
                    @elseif ($pesanan->status === 'Menunggu Verifikasi')
                    <span class="inline-block bg-blue-200 text-blue-800 font-semibold px-3 py-1 rounded-full text-xs">Awaiting Verification</span>
                    @elseif ($pesanan->status === 'Selesai')
                    <span class="inline-block bg-green-200 text-green-800 font-semibold px-3 py-1 rounded-full text-xs">Completed</span>
                    @elseif ($pesanan->status === 'Dibatalkan')
                    <span class="inline-block bg-red-200 text-red-800 font-semibold px-3 py-1 rounded-full text-xs">Cancelled</span>
                    @endif
                </div>
                <div>
                    <p class="opacity-80">Payment Deadline</p>
                    <p class="font-semibold">
                        {{ $pesanan->batas_waktu_pembayaran->format('d M Y - H:i') }}
                    </p>
                </div>
                <div class="mt-6">
                    @if ($pesanan->status === 'Menunggu Pembayaran' && now()->lessThan($pesanan->batas_waktu_pembayaran))
                    <!-- UPLOAD PROOF -->
                    <form action="/upload-bukti" method="POST" enctype="multipart/form-data" class="space-y-3" x-data="{ fileName: '' }">
                        @csrf
                        <label class="block text-sm font-medium text-[#3E3A39]">Upload Payment Proof</label>

                        <input type="file" name="bukti" class="hidden" id="upload-bukti" x-on:change="fileName = $event.target.files[0].name" required>
                        <label for="upload-bukti" class="cursor-pointer inline-block bg-[#414833] text-white text-sm px-4 py-2 rounded hover:bg-[#BFA6A0] transition-colors">
                            Choose File
                        </label>
                        <span class="block text-sm text-[#3E3A39] italic" x-text="fileName ? fileName : 'No file selected'"></span>
                        <button type="submit" class="block bg-[#414833] text-white px-5 py-2 rounded hover:bg-[#BFA6A0] transition-colors">
                            Upload Proof
                        </button>
                    </form>

                    @elseif ($pesanan->status === 'Menunggu Pembayaran' && now()->greaterThan($pesanan->batas_waktu_pembayaran))
                    <!-- PAYMENT EXPIRED -->
                    <p class="text-red-600 font-semibold text-sm">
                        Payment time has expired. The transaction was automatically canceled.
                    </p>

                    @elseif ($pesanan->status === 'Menunggu Verifikasi' || $pesanan->status === 'Selesai')
                    <!-- ALREADY UPLOADED -->
                    <div class="text-sm text-[#3E3A39]">
                        <p class="mb-2">Proof of payment has been submitted.</p>
                        @if ($pesanan->pembayaran && $pesanan->pembayaran->path_bukti)
                        <img src="{{ asset('storage/' . $pesanan->pembayaran->path_bukti) }}" alt="Payment Proof" class="w-64 border rounded shadow">
                        @else
                        <p class="italic text-gray-500">Proof not found.</p>
                        @endif
                    </div>
                    @elseif ($pesanan->status === 'Dibatalkan')
                    <p class="text-red-600 font-semibold text-sm">
                        Payment time has expired. The transaction was automatically canceled.
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- RIGHT: QR Code -->
        <div class="md:w-1/2 w-full bg-white p-8 rounded-lg shadow-lg flex flex-col items-center justify-center text-center space-y-4">
            <h2 class="text-2xl font-bold text-[#3E3A39]">Scentscape</h2>
            <p class="text-sm text-[#3E3A39]">NMID : ID123456781234944</p>

            <div class="bg-[#F6F1EB] p-4 rounded-lg border border-[#D6C6B8]">
                <img src="{{ asset('images/qr-scentscape.png') }}" alt="QR-code" class="h-60 w-60 object-contain">
            </div>

            <p class="text-[#3E3A39] text-base font-medium">Scan the QR to make a payment of:</p>
            <p class="text-2xl font-bold">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>

            <a href="/home">
                <button class="mt-4 bg-[#BFA6A0] text-white px-6 py-2 rounded hover:bg-[#9BAF9A] transition-all">
                    Back to Home
                </button>
            </a>
        </div>
    </div>
</div>
@endsection