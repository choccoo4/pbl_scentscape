@extends('layouts.seller')
@section('title', 'Daftar Pesanan - Scentscape')
@section('content')

<div class="px-4 md:px-6 lg:px-10">
    <h1 class="text-2xl mb-4 flex items-center gap-2">
        <i class="fa-solid fa-clipboard-list mr-2"></i> Daftar Pesanan
    </h1>
    <hr class="mb-6 border-gray-400">

    <!-- Tab Status + Search -->
    <div class="mb-4 flex flex-wrap items-end justify-between gap-4">
        @php
        $statusCounts = [
        'Menunggu Pembayaran' => $pesanan->where('status', 'Menunggu Pembayaran')->count(),
        'Menunggu Verifikasi' => $pesanan->where('status', 'Menunggu Verifikasi')->count(),
        'Dikemas' => $pesanan->where('status', 'Dikemas')->count(),
        'Dikirim' => $pesanan->whereIn('status', ['Dikirim', 'Terkirim'])->count()
        ];
        @endphp
        @foreach (['Semua', 'Menunggu Pembayaran', 'Menunggu Verifikasi', 'Dikemas', 'Dikirim', 'Selesai', 'Dibatalkan'] as $tab)
        @php
        $statusParam = strtolower(str_replace(' ', '_', $tab));
        $statusParam = $tab === 'Semua' ? '' : $statusParam;
        $badgeCount = $tab !== 'Semua' ? ($statusCounts[$tab] ?? 0) : '';
        @endphp
        <a href="{{ url()->current() }}{{ $statusParam ? '?status=' . $statusParam : '' }}"
            class="relative px-4 py-2 rounded-md font-medium text-sm
                {{ (request('status') === $statusParam) || ($tab === 'Semua' && !request('status')) 
                    ? 'bg-[#8B3E00] text-white' 
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            {{ $tab }}
            @if ($badgeCount)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $badgeCount }}</span>
            @endif
        </a>
        @endforeach

        <!-- Search Box -->
        <form action="{{ url()->current() }}" method="GET" class="flex-grow max-w-md">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full bg-white border border-gray-300 text-sm rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-brown-600"
                placeholder="Cari pesanan..." />
        </form>
    </div>

    <!-- Tabel Pesanan -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-3 font-medium">No</th>
                    <th class="px-4 py-3 font-medium">Tanggal Pemesanan</th>
                    <th class="px-4 py-3 font-medium">ID Pesanan</th>
                    <th class="px-4 py-3 font-medium">Pembayaran</th>
                    <th class="px-4 py-3 font-medium">Total Belanja</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pesanan as $index => $p)
                <tr class="hover:bg-gray-50 {{ in_array($p->status, ['Menunggu Verifikasi', 'Dikemas']) ? 'bg-yellow-50' : '' }}">
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
                                    ($p->status === 'Dikirim' ? 'bg-cyan-200 text-cyan-800' :
                                    ($p->status === 'Selesai' ? 'bg-green-200 text-green-800' :
                                    ($p->status === 'Dibatalkan' ? 'bg-red-200 text-red-800' : 'bg-gray-200 text-gray-800'))))) 
                                }}">
                            {{ $p->status }}
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
                                    $p->status === 'Menunggu Verifikasi' ? 'Verifikasi Sekarang' :
                                    ($p->status === 'Dikemas' ? 'Kirim Sekarang' : 'Detail Transaksi') 
                                }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Tidak ada data pesanan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($pesanan->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $pesanan->links('pagination::tailwind-custom') }}
    </div>
    @endif
</div>

@endsection