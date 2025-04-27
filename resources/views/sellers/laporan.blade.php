@extends('layouts.penjual')

@section('content')
<h1 class="text-2xl mb-4 flex items-center gap-2">📢 Rekapitulasi Penjualan</h1>
<hr class="mb-6 border-gray-400">

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <div class="flex justify-end p-2">
            <input type="text" placeholder="Search..." class="border border-gray-300 rounded px-3 py-1 text-sm">
        </div>
        <table class="w-full text-sm text-left border-t border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border-t border-b">No</th>
                    <th class="px-4 py-2 border-t border-b">Barang</th>
                    <th class="px-4 py-2 border-t border-b">Harga</th>
                    <th class="px-4 py-2 border-t border-b">QTY</th>
                    <th class="px-4 py-2 border-t border-b">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-gray-100 text-center">
                    <td class="px-4 py-2">1</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                </tr>
            </tbody>
        </table>

        <div class="p-4 text-lg font-semibold">
            Grand Total : Rp. 0
        </div>
    </div>

    <div class="mt-4">
        <button class="bg-teal-700 text-white px-4 py-2 rounded hover:bg-teal-800">
            Print
        </button>
    </div>
</div>
@endsection
