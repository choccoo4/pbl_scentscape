@extends('layouts.app')
@section('title', 'History Order')

@section('content')
<div class="bg-[#FDF6EF] min-h-screen py-10 px-4">
    <div class="flex flex-col md:flex-row max-w-6xl mx-auto gap-6">
        <!-- Sidebar -->
        @include('components.sidebar-profile')

        <!-- Main Content -->
        <main class="flex-1 bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-semibold mb-6 border-b pb-3 text-[#3E3A39]">Order History</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100 text-[#3E3A39]">
                        <tr class="text-center">
                            <th class="px-4 py-3 border">Order Number</th>
                            <th class="px-4 py-3 border">Date</th>
                            <th class="px-4 py-3 border">Total Amount</th>
                            <th class="px-4 py-3 border">Status</th>
                            <th class="px-4 py-3 border">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($pesanan as $item)
                        <tr class="text-center">
                            <td class="px-4 py-3 border">{{ $item->nomor_pesanan }}</td>
                            <td class="px-4 py-3 border">{{ \Carbon\Carbon::parse($item->waktu_pemesanan)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 border">Rp {{ number_format($item->total + $item->ongkir, 0, ',', '.') }}</td>
                            @php
                            $statusMap = [
                            'Menunggu Pembayaran' => 'Waiting for Payment',
                            'Menunggu Verifikasi' => 'Awaiting Verification',
                            'Dikemas' => 'Being Packed',
                            'Dikirim' => 'Shipped',
                            'Terkirim' => 'Delivered',
                            'Selesai' => 'Completed',
                            'Dibatalkan' => 'Cancelled',
                            'Ditolak' => 'Rejected',
                            ];
                            @endphp
                            <td class="px-4 py-3 border font-semibold text-{{ 
                                $item->status === 'Terkirim' || $item->status === 'Selesai' ? 'green-600' :
                                ($item->status === 'Dibatalkan' || $item->status === 'Ditolak' ? 'red-600' : 'yellow-600') }}">
                                {{ $statusMap[$item->status] ?? $item->status }}
                            </td>
                            <td class="px-4 py-3 border text-blue-600 underline">
                                @if ($item->status === 'Menunggu Pembayaran')
                                <a href="{{ route('transaksi.detail', $item->id_pesanan) }}" class="text-yellow-600 hover:underline" target="_blank">Pay Now</a>
                                @elseif(in_array($item->status, ['Menunggu Verifikasi', 'Dibatalkan', 'Selesai', 'Dikirim', 'Dikemas', 'Terkirim', 'Ditolak']))
                                <a href="{{ route('invoice.generate', $item->id_pesanan) }}" class="text-blue-600 hover:underline" target="_blank">View Invoice</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No orders yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection