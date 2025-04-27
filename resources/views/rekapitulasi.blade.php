@extends('layouts.penjual')

@section('content')
<h1 class="text-2xl mb-4 flex items-center gap-2">
<i class="fa-solid fa-chart-line mr-2"></i> Rekapitulasi Penjualan</h1>
<hr class="mb-6 border-gray-400">


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Laporan Harian -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-xl mx-auto mt-6">
    <!-- Header dengan latar hijau penuh -->
    <div class="bg-teal-700 px-4 py-2">
        <h2 class="text-sm font-semibold text-white">Laporan Harian</h2>
    </div>

    <!-- Konten Form -->
    <form class="p-4">
        <div class="flex gap-4 mb-4">
            <div class="flex-1">
                <label class="block text-sm mb-1">Tanggal</label>
                <input type="number" name="tanggal" class="w-full border rounded px-2 py-1 bg-gray-200" value="1" min="1" max="31">
            </div>
            <div class="flex-1">
                <label class="block text-sm mb-1">Bulan</label>
                <input type="number" name="bulan" class="w-full border rounded px-2 py-1 bg-gray-200" value="1" min="1" max="12">
            </div>
            <div class="flex-1">
                <label class="block text-sm mb-1">Tahun</label>
                <input type="number" name="tahun" class="w-full border rounded px-2 py-1 bg-gray-200" value="2025" min="2000">
            </div>
        </div>

        <button type="submit" class="bg-teal-700 text-white px-3 py-2 rounded hover:bg-teal-800 w-full text-lg">
            Cetak Laporan
        </button>
    </form>
</div>


         <!-- Laporan Bulanan -->
         <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-xl mx-auto mt-6">
    <!-- Header dengan latar hijau penuh -->
    <div class="bg-teal-700 px-4 py-2">
        <h2 class="text-sm font-semibold text-white">Laporan Bulanan</h2>
    </div>

    <!-- Konten Form -->
    <form class="p-4">
        <div class="flex gap-4 mb-4">
            <div class="flex-1">
                <label class="block text-sm mb-1">Bulan</label>
                <input type="number" name="bulan" class="w-full border rounded px-2 py-1 bg-gray-200" value="1" min="1" max="12">
            </div>
            <div class="flex-1">
                <label class="block text-sm mb-1">Tahun</label>
                <input type="number" name="tahun" class="w-full border rounded px-2 py-1 bg-gray-200" value="2025" min="2000">
            </div>
        </div>

        <button type="submit" class="bg-teal-700 text-white px-3 py-2 rounded hover:bg-teal-800 w-full text-lg">
            Cetak Laporan
        </button>
    </form>
</div>

        <!-- Laporan Tahunan -->
         <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-xl mx-auto mt-6">
    <!-- Header dengan latar hijau penuh -->
    <div class="bg-teal-700 px-4 py-2">
        <h2 class="text-sm font-semibold text-white">Laporan Tahunan</h2>
    </div>

    <!-- Konten Form -->
    <form class="p-4">
        <div class="flex gap-4 mb-4">
            <div class="flex-1">
                <label class="block text-sm mb-1">Tahun</label>
                <input type="number" name="tahun" class="w-full border rounded px-2 py-1 bg-gray-200" value="2025" min="2000">
            </div>
        </div>

        <button type="submit" class="bg-teal-700 text-white px-3 py-2 rounded hover:bg-teal-800 w-full text-lg">
            Cetak Laporan
        </button>
    </form>
</div>
    </div>
</div>
@endsection
