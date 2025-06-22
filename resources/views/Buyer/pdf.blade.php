<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #333;
        }

        h2,
        h4 {
            margin: 0;
        }

        .section {
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            width: 300px;
            float: right;
            margin-top: 20px;
        }

        .summary td {
            border: none;
            padding: 4px 8px;
        }

        .summary td.label {
            font-weight: bold;
        }

        .total-final {
            font-weight: bold;
            font-size: 16px;
        }

        .shipping-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }

        .shipping-info h4 {
            color: #007bff;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="section">
        <h2>Invoice</h2>
        <p><strong>Nomor Pesanan:</strong> {{ $pesanan->nomor_pesanan }}</p>
        <p><strong>Tanggal:</strong> {{ $pesanan->waktu_pemesanan->format('d M Y H:i') }}</p>
        <p><strong>Status:</strong> {{ $pesanan->status }}</p>
    </div>

    <div class="section">
        <h4>Informasi Pembeli</h4>
        <p><strong>Nama:</strong> {{ $pesanan->pembeli->pengguna->nama ?? '-' }}</p>
        <p><strong>No. HP:</strong> {{ $pesanan->pembeli->no_telp ?? '-' }}</p>
        <p><strong>Alamat Pengiriman:</strong> {{ $pesanan->pembeli->alamat ?? '-' }}</p>
    </div>

    <!-- Informasi Pengiriman (hanya tampil jika ada data pengiriman) -->
    @if($pesanan->pengiriman && ($pesanan->status == 'Dikirim' || $pesanan->status == 'Selesai'))
    <div class="shipping-info">
        <h4>Informasi Pengiriman</h4>
        <p><strong>Nomor Resi:</strong> {{ $pesanan->pengiriman->nomor_resi ?? '-' }}</p>
        
        <!-- Coba berbagai kemungkinan nama field untuk tanggal kirim -->
        @if($pesanan->pengiriman->waktu_dikirim)
        <p><strong>Tanggal Dikirim:</strong> {{ \Carbon\Carbon::parse($pesanan->pengiriman->waktu_dikirim)->format('d M Y') }}</p>
        @elseif($pesanan->pengiriman->tanggal_kirim)
        <p><strong>Tanggal Dikirim:</strong> {{ \Carbon\Carbon::parse($pesanan->pengiriman->tanggal_kirim)->format('d M Y') }}</p>
        @elseif($pesanan->pengiriman->created_at)
        <p><strong>Tanggal Dikirim:</strong> {{ \Carbon\Carbon::parse($pesanan->pengiriman->created_at)->format('d M Y') }}</p>
        @elseif($pesanan->pengiriman->waktu_pengiriman)
        <p><strong>Tanggal Dikirim:</strong> {{ \Carbon\Carbon::parse($pesanan->pengiriman->waktu_pengiriman)->format('d M Y') }}</p>
        @endif
    </div>
    @endif

    <div class="section">
        <h4>Daftar Produk</h4>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->items as $item)
                <tr>
                    <td>{{ $item->nama_produk }}</td>
                    <td class="text-right">{{ $item->jumlah }}</td>
                    <td class="text-right">Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <table class="summary">
        <tr>
            <td class="label">Subtotal</td>
            <td class="text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Ongkos Kirim</td>
            <td class="text-right">Rp{{ number_format($pesanan->ongkir, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label total-final">Total Akhir</td>
            <td class="text-right total-final">Rp{{ number_format($pesanan->total, 0, ',', '.') }}</td>
        </tr>
    </table>

</body>

</html>