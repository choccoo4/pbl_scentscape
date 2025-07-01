@extends('layouts.seller')
@section('title', 'Daily Sales Summary - Scentscape')

@section('content')
<div class="bg-[#f6f1eb] shadow rounded-xl p-6 md:px-8">
    <form method="GET" action="{{ route('rekap.index') }}">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold flex items-center gap-3 text-[#3e3a39]">
                <i class="fa-solid fa-chart-line text-[#bfa6a0]"></i> Sales Summary
            </h1>
            <hr class="mb-8 mt-2 border-[#9baf9a]">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-2">
                <label class="text-sm font-medium text-[#3e3a39] flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-[#9baf9a]"></i> Start Date
                </label>
                <input type="date" name="tanggal_awal" 
                       class="w-full border-2 border-[#bfa6a0] rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#9baf9a] focus:border-[#9baf9a] transition-colors bg-white shadow-sm" 
                       value="{{ request('tanggal_awal') }}">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium text-[#3e3a39] flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-[#9baf9a]"></i> End Date
                </label>
                <input type="date" name="tanggal_akhir" 
                       class="w-full border-2 border-[#bfa6a0] rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#9baf9a] focus:border-[#9baf9a] transition-colors bg-white shadow-sm" 
                       value="{{ request('tanggal_akhir') }}">
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <button type="submit"
                class="inline-flex items-center px-6 py-3 rounded-md bg-[#9baf9a] text-white font-medium hover:bg-[#89a48a] hover:shadow-md transition duration-200 ease-in-out">
                <i class="fa-solid fa-magnifying-glass mr-2"></i> Show Data
            </button>

            @if(request('tanggal_awal') && request('tanggal_akhir') && $penjualan->count() > 0)
            <a href="{{ route('rekap.pdf', request()->all()) }}"
                class="inline-flex items-center px-6 py-3 rounded-lg bg-gradient-to-r from-red-500 to-red-600 text-white font-medium hover:from-red-600 hover:to-red-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="fa-solid fa-file-pdf mr-2"></i> Export PDF
            </a>

            <a href="{{ route('rekap.excel', request()->all()) }}"
                class="inline-flex items-center px-6 py-3 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white font-medium hover:from-green-600 hover:to-green-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="fa-solid fa-file-excel mr-2"></i> Export Excel
            </a>
            @endif
        </div>
    </form>

    @if (request('tanggal_awal') && request('tanggal_akhir'))
    @if($penjualan->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-lg p-4 border border-[#d6c6b8] shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fa-solid fa-shopping-cart text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Transactions</p>
                    <p class="text-xl font-semibold text-[#3e3a39]">{{ $penjualan->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 border border-[#d6c6b8] shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fa-solid fa-box text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Items Sold</p>
                    <p class="text-xl font-semibold text-[#3e3a39]">{{ $penjualan->sum('jumlah') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 border border-[#d6c6b8] shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fa-solid fa-money-bill-wave text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Revenue</p>
                    <p class="text-xl font-semibold text-[#3e3a39]">Rp. {{ number_format($grandTotal, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="mt-8">
        <div class="bg-white rounded-t-lg px-6 py-4 border-b border-[#d6c6b8]">
            <h3 class="text-lg font-semibold text-[#3e3a39] flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-[#9baf9a]"></i>
                Period: {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d F Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d F Y') }}
            </h3>
        </div>

        <div class="overflow-x-auto bg-white rounded-b-lg border border-[#d6c6b8] shadow-sm">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-[#9baf9a] to-[#89a48a] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Unit Price</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">QTY</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($penjualan as $index => $item)
                    <tr class="hover:bg-[#f9f7f4] transition-colors duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-2 h-2 bg-[#9baf9a] rounded-full mr-3"></div>
                                <div class="text-sm font-medium text-[#3e3a39]">
                                    {{ $item->pesanan ? $item->pesanan->waktu_pemesanan->format('d-m-Y') : '-' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($item->produk && $item->produk->gambar)
                                        @php
                                            $gambar = $item->produk->gambar;
                                            $imagePath = is_array($gambar) ? ($gambar[0] ?? '') : $gambar;
                                        @endphp
                                        <img src="{{ asset('storage/' . $imagePath) }}" 
                                        alt="{{ $item->produk->nama_produk }}" 
                                        class="w-16 h-16 object-cover rounded-lg shadow-sm border border-gray-200"
                                        data-fallback="{{ asset('images/no-image.png') }}"
                                        onerror="this.src=this.dataset.fallback">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
                                            <i class="fa-solid fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-[#3e3a39] truncate">
                                        {{ $item->produk ? $item->produk->nama_produk : ($item->nama_produk ?? 'Product Not Found') }}
                                    </p>
                                    @if($item->produk && $item->produk->tipe_parfum)
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fa-solid fa-tag mr-1"></i>{{ $item->produk->tipe_parfum }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="text-sm font-medium text-[#3e3a39]">
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $item->jumlah }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="text-sm font-bold text-green-600">
                                Rp {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-4"></i>
                                <p class="text-lg text-gray-500">No sales data available</p>
                                <p class="text-sm text-gray-400">for the selected date range</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($penjualan->count() > 0)
                <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right">
                            <span class="text-lg font-semibold text-[#3e3a39]">Total:</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xl font-bold text-green-600 bg-green-50 px-4 py-2 rounded-lg border border-green-200">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
    @else
    <div class="mt-8 bg-white rounded-xl p-8 text-center border border-[#d6c6b8] shadow-sm">
        <div class="max-w-md mx-auto">
            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-[#9baf9a] to-[#89a48a] rounded-full flex items-center justify-center">
                <i class="fa-solid fa-calendar-days text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-[#3e3a39] mb-2">Select Date Range</h3>
            <p class="text-gray-600 mb-6">
                Please select a <strong>start date</strong> and <strong>end date</strong> 
                to view your sales summary.
            </p>
            <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                <i class="fa-solid fa-lightbulb text-yellow-500"></i>
                <span>Tip: Select a shorter range for optimal performance</span>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
