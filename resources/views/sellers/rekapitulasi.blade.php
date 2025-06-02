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
            <button type="submit"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-[#9baf9a] text-white hover:bg-[#89a48a] hover:shadow transition-all">
                <i class="fa-solid fa-magnifying-glass mr-2"></i> Tampilkan
            </button>

            <a href="{{ route('rekap.pdf', request()->all()) }}"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 hover:shadow transition-all">
                <i class="fa-solid fa-file-pdf mr-2 text-red-400"></i> Export PDF
            </a>

            <a href="{{ route('rekap.excel', request()->all()) }}"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 hover:shadow transition-all">
                <i class="fa-solid fa-file-excel mr-2 text-green-500"></i> Export Excel
            </a>
        </div>
    </form>

    @if (request('tanggal_awal') && request('tanggal_akhir'))
    <div class="mt-8 overflow-x-auto rounded-lg border border-[#d6c6b8]">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-[#9baf9a] text-white">
                <tr>
                    <th class="px-5 py-3 text-center">Tanggal</th>
                    <th class="px-5 py-3 text-center">Produk</th>
                    <th class="px-5 py-3 text-center">Harga</th>
                    <th class="px-5 py-3 text-center">QTY</th>
                    <th class="px-5 py-3 text-center">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white text-[#3e3a39] text-center">
                @forelse ($penjualan as $item)
                <tr class="hover:bg-[#f6f1eb] transition">
                    <td class="px-5 py-3">{{ $item->pesanan->waktu_pemesanan->format('d-m-Y') }}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-center gap-3">
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-12 h-12 object-cover rounded">
                            <span>{{ $item->produk->nama_produk }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="px-5 py-3">{{ $item->jumlah }}</td>
                    <td class="px-5 py-3">Rp. {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-[#3e3a39]">Tidak ada data penjualan pada rentang tanggal tersebut.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-end mt-6 pr-6">
            <div class="text-right">
                <div class="text-lg text-[#3e3a39]">Grand Total</div>
                <div class="text-2xl font-semibold text-[#3e3a39]">Rp. {{ number_format($grandTotal, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    @else
    <div class="mt-8 p-6 text-center text-[#3e3a39] bg-[#fff] border border-[#d6c6b8] rounded-lg shadow-sm">
        <p class="text-lg">Silakan pilih <strong>tanggal awal</strong> dan <strong>tanggal akhir</strong> terlebih dahulu untuk melihat rekapitulasi.</p>
    </div>
    @endif
</div>
@endsection