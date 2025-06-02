<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapPenjualanExport;

class RekapitulasiController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = PesananItem::with('produk')
            ->whereHas('pesanan', function ($q) use ($tanggalAwal, $tanggalAkhir) {
                if ($tanggalAwal && $tanggalAkhir) {
                    $q->whereBetween('waktu_pemesanan', [
                        Carbon::parse($tanggalAwal)->startOfDay(),
                        Carbon::parse($tanggalAkhir)->endOfDay()
                    ]);
                }
            });

        $penjualan = $query->get();

        $grandTotal = $penjualan->sum(function ($item) {
            return $item->harga_satuan * $item->jumlah;
        });

        return view('sellers.rekapitulasi', compact('penjualan', 'grandTotal'));
    }

    public function exportPdf(Request $request)
    {
        // Ambil data sama seperti index
        $penjualan = $this->getFilteredData($request);
        $grandTotal = $penjualan->sum(fn($item) => $item->harga_satuan * $item->jumlah);

        $pdf = Pdf::loadView('exports.rekap_pdf', compact('penjualan', 'grandTotal'));
        return $pdf->download('rekapitulasi-penjualan.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new RekapPenjualanExport($request), 'rekapitulasi-penjualan.xlsx');
    }

    // Fungsi untuk re-use query
    private function getFilteredData(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        return PesananItem::with('produk', 'pesanan')
            ->whereHas('pesanan', function ($q) use ($tanggalAwal, $tanggalAkhir) {
                if ($tanggalAwal && $tanggalAkhir) {
                    $q->whereBetween('waktu_pemesanan', [
                        Carbon::parse($tanggalAwal)->startOfDay(),
                        Carbon::parse($tanggalAkhir)->endOfDay()
                    ]);
                }
            })->get();
    }
}
