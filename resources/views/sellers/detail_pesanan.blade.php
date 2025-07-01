@extends('layouts.seller')

@section('title', 'Order Detail')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <div class="bg-[#6b7563] text-white px-6 py-4 text-lg font-semibold">
        Order Detail
    </div>

    <div class="p-6 space-y-6">

        {{-- Confirmation Section --}}
        <div class="bg-[#f8f9fa] border border-[#e9ecef] rounded-md p-4 mt-6">
            @switch($pesanan->status)
            @case('Menunggu Verifikasi')
            <div class="text-[#d63384] font-semibold mb-1">Need Confirmation</div>
            <div class="text-sm text-[#6c757d] mb-3">Please confirm or reject this order.</div>
            <div class="flex gap-2">
                <form method="POST" action="{{ route('pesanan.tolak', $pesanan->id_pesanan) }}">
                    @csrf
                    <button type="submit" class="bg-[#b8860b] hover:bg-[#9a7209] text-white py-2 px-4 rounded text-sm font-medium">Reject Order</button>
                </form>
                <form method="POST" action="{{ route('pesanan.konfirmasi', $pesanan->id_pesanan) }}">
                    @csrf
                    <button type="submit" class="bg-[#6c757d] hover:bg-[#5a6268] text-white py-2 px-4 rounded text-sm font-medium">Confirm Order</button>
                </form>
            </div>
            @break

            @case('Ditolak')
            <div class="text-red-500 font-semibold mb-1">Order Rejected</div>
            <div class="text-sm text-[#6c757d]">This order has been rejected and will not be processed further.</div>
            @break

            @case('Dibatalkan')
            <div class="text-[#dc3545] font-semibold mb-1">Order Cancelled</div>
            <div class="text-sm text-[#6c757d]">This order was cancelled by the system due to payment timeout.</div>
            @break

            @case('Dikemas')
            <div class="text-[#6c757d] font-semibold mb-3">Ship this order package immediately</div>
            <form method="POST" action="{{ route('pesanan.kirim', $pesanan->id_pesanan) }}">
                @csrf
                <button type="submit" class="bg-[#9BAF9A] hover:bg-[#87a088] text-white py-2 px-4 rounded text-sm font-medium">Ship</button>
            </form>
            @break

            @case('Dikirim')
            <div class="text-[#6c757d] font-semibold mb-3">Enter the shipment tracking number</div>
            <form method="POST" action="{{ route('pesanan.terkirim', $pesanan->id_pesanan) }}">
                @csrf
                <div class="flex items-center gap-2">
                    <input type="text" name="nomor_resi" class="border border-gray-300 rounded px-3 py-2 text-sm w-64" placeholder="Sicepat Tracking Number..." required>
                    <button type="submit" class="bg-[#9BAF9A] hover:bg-[#87a088] text-white py-2 px-4 rounded text-sm font-medium transition-colors">Submit</button>
                </div>
            </form>
            @break

            @case('Terkirim')
            <div class="text-[#6c757d] font-semibold mb-3">Has the buyer received the order?</div>
            <form method="POST" action="{{ route('pesanan.selesai', $pesanan->id_pesanan) }}">
                @csrf
                <button type="submit" class="bg-[#9BAF9A] hover:bg-[#87a088] text-white py-2 px-4 rounded text-sm font-medium">Complete</button>
            </form>
            @break

            @case('Selesai')
            <div class="text-[#198754] font-semibold mb-1">Order Completed</div>
            <div class="text-sm text-[#6c757d]">The order has been completed. Thank you for your cooperation.</div>
            @break

            @default
            {{-- Waiting for Payment shows no action --}}
            @endSwitch

            @if(in_array($pesanan->status, ['Terkirim', 'Selesai']) && $pesanan->pengiriman && $pesanan->pengiriman->nomor_resi)
            <div class="mt-4 p-4 border border-[#e9ecef] rounded-md bg-[#f0f4f8] space-y-2">
                <div>
                    <div class="text-sm text-[#6c757d] mb-1 font-medium">Tracking Number:</div>
                    <div class="text-base font-semibold text-[#333]">{{ $pesanan->pengiriman->nomor_resi }}</div>
                </div>
                @if($pesanan->pengiriman->tanggal_kirim)
                <div>
                    <div class="text-sm text-[#6c757d] mb-1 font-medium">Shipped Date:</div>
                    <div class="text-base font-semibold text-[#333]">
                        {{ \Carbon\Carbon::parse($pesanan->pengiriman->tanggal_kirim)->translatedFormat('d F Y') }}
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>


        {{-- Order Details --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">Order Details</div>
            <div class="grid grid-cols-3 gap-y-2 text-sm">
                <div class="font-medium text-[#555]">Order No.:</div>
                <div class="col-span-2 text-[#333]">#{{ $pesanan->nomor_pesanan }}</div>

                <div class="font-medium text-[#555]">Order Date:</div>
                <div class="col-span-2 text-[#333]">{{ \Carbon\Carbon::parse($pesanan->waktu_pemesanan)->translatedFormat('d F Y') }}</div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">
                <i class="fas fa-map-marker-alt text-[#dc3545] mr-2"></i>
                Shipping Address
            </div>
            <div class="bg-[#f8f9fa] rounded-md p-4">
                <div class="font-semibold text-[#333] mb-1">{{ $pesanan->pengguna->nama }}</div>
                <div class="text-sm text-[#6c757d] mb-1">{{ $pesanan->pembeli->no_telp }}</div>
                <div class="text-sm text-[#333]">{{ $pesanan->pembeli->alamat }}</div>
            </div>
        </div>

        {{-- Payment Info --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">
                <i class="fas fa-credit-card text-[#28a745] mr-2"></i>
                Payment Information
            </div>

            {{-- Payment Details Table --}}
            <div class="bg-[#f8f9fa] rounded-md p-4 mb-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[#dee2e6]">
                                <th class="text-left py-2 font-medium text-[#555]">No.</th>
                                <th class="text-left py-2 font-medium text-[#555]">Product</th>
                                <th class="text-right py-2 font-medium text-[#555]">Unit Price</th>
                                <th class="text-right py-2 font-medium text-[#555]">Quantity</th>
                                <th class="text-right py-2 font-medium text-[#555]">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->items as $i => $item)
                            <tr class="border-b border-[#e9ecef]">
                                <td class="py-2">{{ $i + 1 }}</td>
                                <td class="py-2">{{ $item->nama_produk }}</td>
                                <td class="py-2 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="py-2 text-right">{{ $item->jumlah }}</td>
                                <td class="py-2 text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Payment Summary --}}
            <div class="flex justify-between">
                <span class="text-[#555]">Order Subtotal</span>
                <span class="font-semibold">Rp {{ number_format($pesanan->total - $pesanan->ongkir, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-[#555]">Shipping Fee Paid by Buyer</span>
                <span class="font-semibold">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between border-t-2 border-[#333] pt-3 mt-3 font-bold text-base">
                <span class="text-[#333]">Total</span>
                <span class="text-[#dc3545] text-lg">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
            </div>

            {{-- Payment Proof --}}
            @if($pesanan->pembayaran)
            <div class="text-base font-semibold text-[#333] mb-4">
                Payment Proof
            </div>
            <img src="{{ asset('storage/' . $pesanan->pembayaran->path_bukti) }}" alt="Payment Proof" class="max-w-xs mx-auto rounded-md">
            @else
            <div class="italic text-[#6c757d] text-sm">Payment proof not available</div>
            @endif

        </div>

        {{-- Products --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">Purchased Products</div>
            @foreach($pesanan->items as $item)
            <div class="bg-[#f8f9fa] rounded-md p-4 mb-3 flex items-center gap-4">
                <div class="w-16 h-16 rounded-md overflow-hidden flex items-center justify-center bg-[#eee]">
                    @if($item->gambar_produk)
                    <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="object-cover w-full h-full" alt="{{ $item->nama_produk }}">
                    @else
                    <div class="text-xs text-[#666] text-center">No<br>Image</div>
                    @endif
                </div>
                <div class="flex-1">
                    <div class="font-semibold text-[#333]">{{ $item->nama_produk }}</div>
                    <div class="text-sm text-[#6c757d]">Unit Price: Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>
                    <div class="text-sm text-[#6c757d]">Quantity: {{ $item->jumlah }}</div>
                </div>
                <div class="font-semibold text-[#333] text-sm">
                    Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="border-t border-[#e9ecef] pt-4 space-y-2 text-sm">
            <div class="flex justify-between">
                <div class="text-[#555]">Product Subtotal:</div>
                <div class="font-semibold text-[#333]">Rp {{ number_format($pesanan->total - $pesanan->ongkir, 0, ',', '.') }}</div>
            </div>
            <div class="flex justify-between">
                <div class="text-[#555]">Shipping Cost:</div>
                <div class="font-semibold text-[#333]">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</div>
            </div>
            <div class="flex justify-between border-t border-[#e9ecef] pt-2 mt-2 text-base font-bold">
                <div class="text-[#333]">Grand Total:</div>
                <div class="text-[#333]">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
