@extends('layouts.app')
@section('title', 'History Order')

@section('content')
<div class="bg-[#FDF6EF] min-h-screen py-10 px-4">
    <div class="flex flex-col md:flex-row max-w-6xl mx-auto gap-6">
        <!-- Sidebar -->
        <aside class="w-1/4 md:w-1/5 bg-[#FDF6EF] p-4 md:p-6">
            <div class="flex items-center gap-4 mb-6 px-2">
                <img src="/images/profile.png" class="w-10 h-10 rounded-full" alt="Profile Icon">
                <p class="font-semibold text-lg">username</p>
            </div>
            <ul class="space-y-2 text-left font-medium ml-4 group">
                <li class="relative">
                    <div class="flex items-center space-x-2 hover:text-[#9BAF9A] transition-all cursor-pointer group-hover:text-[#9BAF9A]">
                        <i class="fas fa-user"></i>
                        <span>My Account</span>
                    </div>
                    <ul class="pl-6 mt-2 space-y-1 text-sm transition-all duration-300 group-hover:max-h-32 max-h-0 overflow-hidden">
                        <li><a href="{{ route('profile') }}" class="hover:text-[#BFA6A0]">Profile</a></li>
                        <li><a href="{{ route('change-pw') }}" class="hover:text-[#BFA6A0]">Change Password</a></li>
                    </ul>
                </li>
                <li class="flex items-center space-x-2 font-medium text-black hover:text-[#9BAF9A]">
                    <i class="fas fa-box"></i>
                    <a href="{{ route('order.history') }}">Order History</a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-semibold mb-6 border-b pb-3 text-[#3E3A39]">Order History</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100 text-[#3E3A39]">
                        <tr class="text-center">
                            <th class="px-4 py-3 border">No. Pesanan</th>
                            <th class="px-4 py-3 border">Tanggal</th>
                            <th class="px-4 py-3 border">Jumlah Total</th>
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
                            <td class="px-4 py-3 border font-semibold text-{{ 
            $item->status === 'Terkirim' || $item->status === 'Selesai' ? 'green-600' :
            ($item->status === 'Dibatalkan' || $item->status === 'Ditolak' ? 'red-600' : 'yellow-600') }}">
                                {{ $item->status }}
                            </td>
                            <td class="px-4 py-3 border text-blue-600 underline">
                                @if ($item->status === 'Menunggu Pembayaran')
                                <a href="{{ route('transaksi.detail', $item->id_pesanan) }}" class="text-yellow-600 hover:underline" target="_blank">Bayar Sekarang</a>
                                @elseif(in_array($item->status, ['Menunggu Verifikasi', 'Dibatalkan', 'Selesai', 'Dikirim', 'Dikemas', 'Terkirim', 'Ditolak']))
                                <a href="{{ route('invoice.generate', $item->id_pesanan) }}" class="text-blue-600 hover:underline" target="_blank">Lihat Invoice</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection