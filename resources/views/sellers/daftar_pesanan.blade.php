@extends('layouts.seller')
@section('title', 'Order List - Scentscape')
@section('content')

<div class="px-4 md:px-6 lg:px-10">
    <h1 class="text-2xl mb-4 flex items-center gap-2">
        <i class="fa-solid fa-clipboard-list mr-2"></i> Order List
    </h1>
    <hr class="mb-6 border-gray-400">

    @php
        $statusTranslations = [
            'Menunggu Pembayaran' => 'Waiting for Payment',
            'Menunggu Verifikasi' => 'Waiting for Verification',
            'Dikemas' => 'Processing',
            'Dikirim' => 'Shipped',
            'Terkirim' => 'Delivered',
            'Selesai' => 'Completed',
            'Dibatalkan' => 'Cancelled'
        ];

        // Menggunakan total dari controller, bukan dari data pagination
        $badgeCounts = $statusCounts ?? [];
    @endphp

    {{-- Tab Filter --}}
    <div class="mb-4 flex flex-wrap items-end justify-between gap-4">
        @foreach (['All', 'Menunggu Pembayaran', 'Menunggu Verifikasi', 'Dikemas', 'Dikirim', 'Selesai', 'Dibatalkan'] as $tab)
            @php
                $statusParam = strtolower(str_replace(' ', '_', $tab));
                $statusParam = $tab === 'All' ? '' : $statusParam;
                $badgeCount = $tab !== 'All' ? ($badgeCounts[$tab] ?? 0) : '';
            @endphp
            <a href="{{ url()->current() }}{{ $statusParam ? '?status=' . $statusParam : '' }}"
                class="relative px-4 py-2 rounded-md font-medium text-sm
                    {{ (request('status') === $statusParam) || ($tab === 'All' && !request('status'))
                        ? 'bg-[#8B3E00] text-white'
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                {{ $tab === 'All' ? 'All' : ($statusTranslations[$tab] ?? $tab) }}

                {{-- Tampilkan badge hanya di halaman pertama --}}
                @if ($pesanan->currentPage() === 1 && $badgeCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                        {{ $badgeCount }}
                    </span>
                @endif
            </a>
        @endforeach

        {{-- Search --}}
        <form action="{{ url()->current() }}" method="GET" class="flex-grow max-w-md">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full bg-white border border-gray-300 text-sm rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-brown-600"
                placeholder="Search order..." />
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-3 font-medium">No</th>
                    <th class="px-4 py-3 font-medium">Order Date</th>
                    <th class="px-4 py-3 font-medium">Order ID</th>
                    <th class="px-4 py-3 font-medium">Payment</th>
                    <th class="px-4 py-3 font-medium">Total</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pesanan as $index => $p)
                <tr class="
                    hover:bg-gray-50
                    {{ in_array($p->status, ['Menunggu Verifikasi', 'Dikemas']) ? 'bg-yellow-50' : '' }}
                    {{ $p->status === 'Selesai' ? 'bg-gray-200 text-gray-400 opacity-60 pointer-events-none' : '' }}
                ">
                    <td class="px-4 py-3">{{ $pesanan->firstItem() + $index }}</td>
                    <td class="px-4 py-3">{{ $p->waktu_pemesanan->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $p->nomor_pesanan }}</td>
                    <td class="px-4 py-3">QRIS</td>
                    <td class="px-4 py-3">Rp{{ number_format($p->total, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full
                            {{ 
                                $p->status === 'Menunggu Pembayaran' ? 'bg-yellow-200 text-yellow-800' :
                                ($p->status === 'Menunggu Verifikasi' ? 'bg-orange-200 text-orange-800' :
                                ($p->status === 'Dikemas' ? 'bg-blue-200 text-blue-800' :
                                ($p->status === 'Dikirim' || $p->status === 'Terkirim' ? 'bg-cyan-200 text-cyan-800' :
                                ($p->status === 'Selesai' ? 'bg-gray-300 text-gray-800' :
                                ($p->status === 'Dibatalkan' ? 'bg-red-200 text-red-800' : 'bg-gray-200 text-gray-800')))))
                            }}">
                            {{ $statusTranslations[$p->status] ?? $p->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('pesanan.detail', $p->id_pesanan) }}"
                            class="text-xs px-3 py-1 rounded font-medium 
                                {{ 
                                    $p->status === 'Menunggu Verifikasi' ? 'bg-orange-600 hover:bg-orange-700 text-white' :
                                    ($p->status === 'Dikemas' ? 'bg-blue-600 hover:bg-blue-700 text-white' :
                                    'bg-green-700 hover:bg-green-800 text-white') 
                                }}">
                            {{
                                $p->status === 'Menunggu Verifikasi' ? 'Verify Now' :
                                ($p->status === 'Dikemas' ? 'Ship Now' : 'View Details')
                            }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($pesanan->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $pesanan->links('pagination::tailwind-custom') }}
    </div>
    @endif
</div>

@endsection
