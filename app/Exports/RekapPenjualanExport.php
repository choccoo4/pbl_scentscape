<?php

namespace App\Exports;

use App\Models\PesananItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class RekapPenjualanExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PesananItem::with(['produk', 'pesanan'])
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal Pesanan' => $item->pesanan->tanggal_pesanan->format('Y-m-d'),
                    'Nama Produk' => $item->produk->nama_produk,
                    'Jumlah' => $item->jumlah,
                    'Harga Satuan' => $item->harga_satuan,
                    'Total' => $item->jumlah * $item->harga_satuan,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal Pesanan',
            'Nama Produk',
            'Jumlah',
            'Harga Satuan',
            'Total',
        ];
    }
}
