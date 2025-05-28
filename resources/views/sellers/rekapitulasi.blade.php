@extends('layouts.seller')
@section('title', 'Rekapitulasi Penjualan Harian - Scentscape')

@section('content')
<div class="bg-[#f6f1eb] shadow rounded-xl p-6 md:px-8">
    <form method="GET" action="{{ route('rekap.index') }}">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold flex items-center gap-3 text-[#3e3a39]">
                <i class="fa-solid fa-chart-line text-[#bfa6a0]"></i> Rekapitulasi Penjualan
            </h1>
            <hr class="mb-8 mt-2 border-[#9baf9a]">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="text-sm text-[#3e3a39] mb-1 block">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="w-full border border-[#bfa6a0] rounded-md px-4 py-2 focus:ring-[#9baf9a]" value="{{ request('tanggal_awal') }}">
            </div>
            <div>
                <label class="text-sm text-[#3e3a39] mb-1 block">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="w-full border border-[#bfa6a0] rounded-md px-4 py-2 focus:ring-[#9baf9a]" value="{{ request('tanggal_akhir') }}">
            </div>
        </div>

       <div class="mt-6 flex gap-4">
    <a href="{{ route('rekap.index') }}" class="bg-[#414833] hover:bg-[#3e3a39] text-white px-6 py-2 rounded-full shadow transition inline-flex items-center">
        <i class="fa-solid fa-file-pdf mr-2 text-red-400"></i> Export PDF
    </a>
    <a href="{{ route('rekap.index') }}" class="bg-[#bfa6a0] hover:bg-[#a98f89] text-white px-6 py-2 rounded-full shadow transition inline-flex items-center">
        <i class="fa-solid fa-file-excel mr-2 text-green-500"></i> Export Excel
    </a>
</div>

    </form>

    <div class="mt-8 overflow-x-auto rounded-lg border border-[#d6c6b8]">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-[#9baf9a] text-white">
                <tr>
                    <th class="px-5 py-3 text-center">Tanggal</th>
                    <th class="px-5 py-3 text-center">Produk</th> <!-- Foto dan Nama Produk jadi satu -->
                    <th class="px-5 py-3 text-center">Harga</th>
                    <th class="px-5 py-3 text-center">QTY</th>
                    <th class="px-5 py-3 text-center">Total</th>
                </tr>
            </thead>
           <tbody class="bg-white text-[#3e3a39] text-center">
    <!-- Contoh Data Statis -->
    <tr class="hover:bg-[#f6f1eb] transition">
        <td class="px-5 py-3">11-02-2025</td>
        <td class="px-5 py-3">
            <div class="flex items-center justify-center gap-3">
                <img src="{{ asset('images/products/image.png') }}" alt="Vanilla Mist" class="w-12 h-12 object-cover rounded">
                <span>Parfum Vanilla Mist</span>
            </div>
        </td>
        <td class="px-5 py-3">Rp. 150.000</td>
        <td class="px-5 py-3">2</td>
        <td class="px-5 py-3">Rp. 300.000</td>
    </tr>
    <tr class="hover:bg-[#f6f1eb] transition">
        <td class="px-5 py-3">13-03-2025</td>
        <td class="px-5 py-3">
            <div class="flex items-center justify-center gap-3">
                <img src="{{ asset('images/products/image2-1.jpg') }}" alt="Citrus Bloom" class="w-12 h-12 object-cover rounded">
                <span>Parfum Citrus Bloom</span>
            </div>
        </td>
        <td class="px-5 py-3">Rp. 120.000</td>
        <td class="px-5 py-3">1</td>
        <td class="px-5 py-3">Rp. 120.000</td>
    </tr>
</tbody>

                <!-- Jika ingin looping data dari controller -->
                {{-- @foreach ($penjualan as $item)
                <tr class="hover:bg-[#f6f1eb] transition">
                    <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td class="px-5 py-3 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}" class="w-12 h-12 object-cover rounded">
                        <span>{{ $item->nama_produk }}</span>
                    </td>
                    <td class="px-5 py-3">Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="px-5 py-3">{{ $item->qty }}</td>
                    <td class="px-5 py-3">Rp. {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>

        <div class="flex justify-end mt-6 pr-6">
    <div class="text-right">
        <div class="text-lg text-[#3e3a39]">Grand Total</div>
        <div class="text-2xl font-semibold text-[#3e3a39]">Rp. 420.000</div>
    </div>
</div>



    </div>
</div>
@endsection
