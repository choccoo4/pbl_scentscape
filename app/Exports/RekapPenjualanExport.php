<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\PesananItem;
use Carbon\Carbon;

class RekapPenjualanExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $tanggalAwal = $this->request->input('tanggal_awal');
        $tanggalAkhir = $this->request->input('tanggal_akhir');

        $penjualan = PesananItem::with(['produk', 'pesanan'])
            ->whereHas('pesanan', function ($q) use ($tanggalAwal, $tanggalAkhir) {
                if ($tanggalAwal && $tanggalAkhir) {
                    $q->whereBetween('waktu_pemesanan', [
                        Carbon::parse($tanggalAwal)->startOfDay(),
                        Carbon::parse($tanggalAkhir)->endOfDay()
                    ]);
                }
            })->get();

        $grandTotal = $penjualan->sum(fn($item) => $item->harga_satuan * $item->jumlah);

        return view('sellers.rekap_excel', compact('penjualan', 'grandTotal'));
    }
}
