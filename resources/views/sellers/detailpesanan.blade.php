@extends('layouts.seller')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <div class="bg-[#6b7563] text-white px-6 py-4 text-lg font-semibold">
        Detail Pesanan
    </div>
    
    <div class="p-6 space-y-6">

        {{-- Confirmation Section --}}
        <div class="bg-[#f8f9fa] border border-[#e9ecef] rounded-md p-4">
            <div class="text-[#d63384] font-semibold mb-1">Perlu Konfirmasi</div>
            <div class="text-sm text-[#6c757d] mb-3">Silakan konfirmasi atau tolak pesanan ini.</div>
            <div class="flex gap-2">
                <button class="bg-[#b8860b] hover:bg-[#9a7209] text-white py-2 px-4 rounded text-sm font-medium">Tolak Pesanan</button>
                <button class="bg-[#6c757d] hover:bg-[#5a6268] text-white py-2 px-4 rounded text-sm font-medium">Konfirmasi Pesanan</button>
            </div>
        </div>

        {{-- Order Details --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">Detail Pesanan</div>
            <div class="grid grid-cols-3 gap-y-2 text-sm">
                <div class="font-medium text-[#555]">No. Pesanan:</div>
                <div class="col-span-2 text-[#333]">#INV20250615001</div>

                <div class="font-medium text-[#555]">Tanggal Pesanan:</div>
                <div class="col-span-2 text-[#333]">15 Juni 2025</div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">
                <i class="fas fa-map-marker-alt text-[#dc3545] mr-2"></i>
                Alamat Pengiriman
            </div>
            <div class="bg-[#f8f9fa] rounded-md p-4">
                <div class="font-semibold text-[#333] mb-1">Ahmad Fauzi</div>
                <div class="text-sm text-[#6c757d] mb-1">(+62) 812-3456-7890</div>
                <div class="text-sm text-[#333]">
                    Jl. Merdeka No. 123, Bandung, Jawa Barat, Indonesia 40123
                </div>
            </div>
        </div>

        {{-- Payment Info --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">
                <i class="fas fa-credit-card text-[#28a745] mr-2"></i>
                Informasi Pembayaran
            </div>
            
            {{-- Payment Details Table --}}
            <div class="bg-[#f8f9fa] rounded-md p-4 mb-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[#dee2e6]">
                                <th class="text-left py-2 font-medium text-[#555]">No.</th>
                                <th class="text-left py-2 font-medium text-[#555]">Produk</th>
                                <th class="text-right py-2 font-medium text-[#555]">Harga Satuan</th>
                                <th class="text-right py-2 font-medium text-[#555]">Jumlah</th>
                                <th class="text-right py-2 font-medium text-[#555]">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-[#e9ecef]">
                                <td class="py-2">1</td>
                                <td class="py-2">Parfum Mewah</td>
                                <td class="py-2 text-right">Rp 75.000</td>
                                <td class="py-2 text-right">2</td>
                                <td class="py-2 text-right font-semibold">Rp 150.000</td>
                            </tr>
                            <tr class="border-b border-[#e9ecef]">
                                <td class="py-2">2</td>
                                <td class="py-2">Parfum Lavender</td>
                                <td class="py-2 text-right">Rp 85.000</td>
                                <td class="py-2 text-right">1</td>
                                <td class="py-2 text-right font-semibold">Rp 85.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Payment Summary --}}
            <div class="bg-[#f8f9fa] rounded-md p-4 mb-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-[#555]">Subtotal Pesanan</span>
                        <span class="font-semibold">Rp 235.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#555]">Ongkir Dibayar Pembeli</span>
                        <span class="font-semibold">Rp 20.000</span>
                    </div>
                    <div class="flex justify-between border-t-2 border-[#333] pt-3 mt-3 font-bold text-base">
                        <span class="text-[#333]">Total</span>
                        <span class="text-[#dc3545] text-lg">Rp 255.000</span>
                    </div>
                </div>
            </div>

            {{-- Payment Proof --}}
            <div>
                <div class="mb-2 font-semibold text-sm">Bukti Pembayaran:</div>
                <div class="bg-[#f8f9fa] border-2 border-dashed border-[#dee2e6] rounded-md py-10 text-center">
                    <i class="fas fa-upload text-4xl text-[#6c757d] mb-3"></i>
                    <div class="italic text-[#6c757d] text-sm">Bukti pembayaran belum diupload</div>
                </div>
            </div>
        </div>

        {{-- Produk --}}
        <div>
            <div class="text-base font-semibold text-[#333] mb-4">Produk yang Dibeli</div>

            {{-- Produk 1 --}}
            <div class="bg-[#f8f9fa] rounded-md p-4 mb-3 flex items-center gap-4">
                <div class="w-16 h-16 bg-[#d4a574] rounded-md flex items-center justify-center text-white text-xs text-center">
                    Parfum<br>Image
                </div>
                <div class="flex-1">
                    <div class="font-semibold text-[#333]">Parfum Mewah</div>
                    <div class="text-sm text-[#6c757d]">Harga Satuan: Rp 75.000</div>
                    <div class="text-sm text-[#6c757d]">Jumlah: 2</div>
                </div>
                <div class="font-semibold text-[#333] text-sm">
                    Subtotal: Rp 150.000
                </div>
            </div>

            {{-- Produk 2 --}}
            <div class="bg-[#f8f9fa] rounded-md p-4 mb-3 flex items-center gap-4">
                <div class="w-16 h-16 bg-[#d4a574] rounded-md flex items-center justify-center text-white text-xs text-center">
                    Parfum<br>Image
                </div>
                <div class="flex-1">
                    <div class="font-semibold text-[#333]">Parfum Lavender</div>
                    <div class="text-sm text-[#6c757d]">Harga Satuan: Rp 85.000</div>
                    <div class="text-sm text-[#6c757d]">Jumlah: 1</div>
                </div>
                <div class="font-semibold text-[#333] text-sm">
                    Subtotal: Rp 85.000
                </div>
            </div>
        </div>

        {{-- Total --}}
        <div class="border-t border-[#e9ecef] pt-4 space-y-2 text-sm">
            <div class="flex justify-between">
                <div class="text-[#555]">Subtotal Produk:</div>
                <div class="font-semibold text-[#333]">Rp 235.000</div>
            </div>
            <div class="flex justify-between">
                <div class="text-[#555]">Ongkos Kirim:</div>
                <div class="font-semibold text-[#333]">Rp 20.000</div>
            </div>
            <div class="flex justify-between border-t border-[#e9ecef] pt-2 mt-2 text-base font-bold">
                <div class="text-[#333]">Grand Total:</div>
                <div class="text-[#333]">Rp 255.000</div>
            </div>
        </div>
    </div>
</div>
@endsection