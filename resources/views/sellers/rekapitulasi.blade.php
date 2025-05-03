@extends('layouts.seller')
@section('title', 'Rekapitulasi Penjualan - Scentscape')

@section('content')
<h1 class="text-3xl font-semibold text-[#414833] mb-4 flex items-center gap-3">
    <i class="fa-solid fa-chart-line text-[#bfa6a0]"></i> Rekapitulasi Penjualan
</h1>
<hr class="mb-8 border-[#9baf9a]">

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @php
    $laporan = [
    ['judul' => 'Laporan Harian', 'fields' => ['tanggal' => 'Tanggal', 'bulan' => 'Bulan', 'tahun' => 'Tahun']],
    ['judul' => 'Laporan Bulanan', 'fields' => ['bulan' => 'Bulan', 'tahun' => 'Tahun']],
    ['judul' => 'Laporan Tahunan', 'fields' => ['tahun' => 'Tahun']],
    ];
    @endphp

    @foreach ($laporan as $form)
    <div class="bg-[#f6f1eb] shadow-md rounded-2xl overflow-hidden border border-[#d6c6b8]">
        <div class="bg-[#414833] px-5 py-3">
            <h2 class="text-base font-semibold text-white tracking-wide">{{ $form['judul'] }}</h2>
        </div>

        <form class="p-5 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-{{ count($form['fields']) }} gap-4">
                @foreach ($form['fields'] as $name => $label)
                <div>
                    <label class="block text-sm text-[#3e3a39] mb-1 font-medium">{{ $label }}</label>
                    <input type="number" name="{{ $name }}"
                        class="w-full rounded-lg border border-[#bfa6a0] px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#9baf9a]"
                        min="{{ $name === 'tahun' ? 2000 : 1 }}"
                        max="{{ $name === 'tanggal' ? 31 : ($name === 'bulan' ? 12 : '') }}"
                        value="{{ $name === 'tahun' ? 2025 : 1 }}">
                </div>
                @endforeach
            </div>

            <a href="{{ route('laporan') }}" class="bg-[#9baf9a] hover:bg-[#8da385] text-white text-sm font-semibold px-4 py-2 rounded-lg w-full transition-all">
                <i class="fa-solid fa-print mr-2"></i> Cetak Laporan
            </a>
        </form>
    </div>
    @endforeach
</div>
@endsection