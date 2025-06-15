<table>
    <thead>
        <tr>
            <th colspan="5" style="font-size: 16px; text-align: center; font-weight: bold; padding: 10px;">
                Rekapitulasi Penjualan
            </th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Nama Produk</th>
            <th>Harga Satuan</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($penjualan as $item)
            <tr>
                <td>{{ $item->pesanan->waktu_pemesanan->format('d-m-Y') }}</td>
                <td>{{ $item->produk->nama_produk }}</td>
                <td>{{ $item->harga_satuan }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->harga_satuan * $item->jumlah }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4"><strong>Grand Total</strong></td>
            <td><strong>{{ $grandTotal }}</strong></td>
        </tr>
    </tbody>
</table>
