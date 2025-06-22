<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Penjualan - Scentscape</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #333;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #9baf9a;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #3e3a39;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        
        .header h2 {
            color: #9baf9a;
            font-size: 18px;
            margin: 5px 0;
            font-weight: normal;
        }
        
        .period {
            background-color: #f6f1eb;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #d6c6b8;
        }
        
        .period strong {
            color: #3e3a39;
            font-size: 14px;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background-color: #9baf9a;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #7a9479;
        }
        
        td {
            padding: 10px 8px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f6f1eb;
        }
        
        .product-info {
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .product-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .product-name {
            font-weight: 500;
            color: #3e3a39;
        }
        
        .price {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        
        .quantity {
            text-align: center;
            font-weight: bold;
        }
        
        .total-row {
            background-color: #f0f0f0 !important;
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 2px solid #9baf9a;
            padding: 15px 8px;
        }
        
        .grand-total {
            background-color: #9baf9a;
            color: white;
            font-size: 16px;
            text-align: right;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .summary-box {
            background-color: #f6f1eb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #d6c6b8;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .summary-item:last-child {
            margin-bottom: 0;
            font-weight: bold;
            font-size: 14px;
            color: #3e3a39;
            border-top: 1px solid #d6c6b8;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        /* Responsive adjustments for PDF */
        @media print {
            body {
                padding: 10px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .header h2 {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌸 SCENTSCAPE</h1>
        <h2>Rekapitulasi Penjualan</h2>
    </div>
    
    @if(isset($tanggalAwal) && isset($tanggalAkhir))
    <div class="period">
        <strong>Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d F Y') }}</strong>
    </div>
    @endif
    
    @if($penjualan->count() > 0)
    {{-- Summary Box --}}
    <div class="summary-box">
        <div class="summary-item">
            <span>Total Transaksi:</span>
            <span>{{ $penjualan->count() }} item</span>
        </div>
        <div class="summary-item">
            <span>Total Quantity:</span>
            <span>{{ $penjualan->sum('jumlah') }} pcs</span>
        </div>
        <div class="summary-item">
            <span>Grand Total:</span>
            <span>Rp. {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th width="12%">Tanggal</th>
                    <th width="40%">Produk</th>
                    <th width="18%">Harga Satuan</th>
                    <th width="10%">QTY</th>
                    <th width="20%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $item)
                <tr>
                    <td>
                        {{ $item->pesanan ? $item->pesanan->waktu_pemesanan->format('d-m-Y') : '-' }}
                    </td>
                    <td>
                        <div class="product-info">
                            @if($item->produk && $item->produk->gambar)
                                @php
                                    $gambar = $item->produk->gambar;
                                    $imagePath = is_array($gambar) ? ($gambar[0] ?? '') : $gambar;
                                    $fullPath = public_path('storage/' . $imagePath);
                                @endphp
                                @if(file_exists($fullPath))
                                    <img src="{{ public_path('storage/' . $imagePath) }}" 
                                         alt="{{ $item->produk->nama_produk }}" 
                                         class="product-image">
                                @else
                                    <div style="width: 40px; height: 40px; background-color: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">
                                        <span style="font-size: 10px; color: #999;">IMG</span>
                                    </div>
                                @endif
                            @else
                                <div style="width: 40px; height: 40px; background-color: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">
                                    <span style="font-size: 10px; color: #999;">IMG</span>
                                </div>
                            @endif
                            <span class="product-name">
                                {{ $item->produk ? $item->produk->nama_produk : ($item->nama_produk ?? 'Produk Tidak Ditemukan') }}
                            </span>
                        </div>
                    </td>
                    <td class="price">
                        Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}
                    </td>
                    <td class="quantity">
                        {{ $item->jumlah }}
                    </td>
                    <td class="price">
                        Rp. {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                
                {{-- Total Row --}}
                <tr class="total-row">
                    <td colspan="4" style="text-align: right; font-weight: bold;">
                        <strong>GRAND TOTAL:</strong>
                    </td>
                    <td class="price" style="font-weight: bold; font-size: 14px;">
                        <strong>Rp. {{ number_format($grandTotal, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    @else
    <div class="no-data">
        <p>📋 Tidak ada data penjualan pada periode yang dipilih</p>
        @if(isset($tanggalAwal) && isset($tanggalAkhir))
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d F Y') }}</p>
        @endif
    </div>
    @endif
    
    <div class="footer">
        <p>Laporan dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }}</p>
        <p>© {{ date('Y') }} Scentscape - e-commerce applicalication</p>
    </div>
</body>
</html>