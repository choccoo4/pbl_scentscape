<table>
    <thead>
        <tr>
            <th colspan="5" style="font-size: 16px; text-align: center; font-weight: bold; padding: 10px; background-color: #9baf9a; color: white;">
                SALES RECAPITULATION
            </th>
        </tr>
        @if(isset($tanggalAwal) && isset($tanggalAkhir))
        <tr>
            <th colspan="5" style="text-align: center; font-size: 12px; padding: 5px;">
                Period: {{ \Carbon\Carbon::parse($tanggalAwal)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y') }}
            </th>
        </tr>
        @endif
        <tr style="background-color: #9baf9a; color: white; font-weight: bold;">
            <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">Date</th>
            <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">Product Name</th>
            <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">Unit Price</th>
            <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">Quantity</th>
            <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $item)
            <tr>
                <td style="text-align: center; padding: 5px; border: 1px solid #ddd;">
                    {{ $item->pesanan ? $item->pesanan->waktu_pemesanan->format('d-m-Y') : '-' }}
                </td>
                <td style="padding: 5px; border: 1px solid #ddd;">
                    {{ $item->produk ? $item->produk->nama_produk : ($item->nama_produk ?? 'Product Not Found') }}
                </td>
                <td style="text-align: right; padding: 5px; border: 1px solid #ddd;">
                    {{ number_format($item->harga_satuan, 0, ',', '.') }}
                </td>
                <td style="text-align: center; padding: 5px; border: 1px solid #ddd;">
                    {{ $item->jumlah }}
                </td>
                <td style="text-align: right; padding: 5px; border: 1px solid #ddd;">
                    {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 10px; border: 1px solid #ddd;">
                    No sales data found for the selected period
                </td>
            </tr>
        @endforelse
        
        @if($penjualan->count() > 0)
        <tr style="background-color: #f0f0f0; font-weight: bold;">
            <td colspan="4" style="text-align: right; padding: 8px; border: 1px solid #ddd;">
                <strong>GRAND TOTAL:</strong>
            </td>
            <td style="text-align: right; padding: 8px; border: 1px solid #ddd;">
                <strong>{{ number_format($grandTotal, 0, ',', '.') }}</strong>
            </td>
        </tr>
        @endif
    </tbody>
</table>
