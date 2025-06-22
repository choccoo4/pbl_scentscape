<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\RekapPenjualan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapPenjualanExport;

class RekapitulasiController extends Controller
{
    // Menampilkan halaman utama rekapitulasi
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $penjualan = collect();
        $grandTotal = 0;

        if ($tanggalAwal && $tanggalAkhir) {
            // Ambil data dan langsung simpan ke database
            $result = $this->getFilteredDataAndSave($request);
            $penjualan = $result['data'];
            $grandTotal = $result['grand_total'];
            
        }

        return view('sellers.rekapitulasi', compact('penjualan', 'grandTotal'));
    }

    // Ekspor data rekap ke PDF
    public function exportPdf(Request $request)
    {
        $result = $this->getFilteredDataAndSave($request);
        $penjualan = $result['data'];
        $grandTotal = $result['grand_total'];

        if ($penjualan->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diekspor');
        }

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $pdf = Pdf::loadView('sellers.rekap_pdf', compact('penjualan', 'grandTotal', 'tanggalAwal', 'tanggalAkhir'));
        $filename = "rekapitulasi-penjualan-{$tanggalAwal}-sampai-{$tanggalAkhir}.pdf";

        return $pdf->download($filename);
    }

    // Ekspor data rekap ke Excel
    public function exportExcel(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if (!$tanggalAwal || !$tanggalAkhir) {
            return redirect()->back()->with('error', 'Silakan pilih tanggal terlebih dahulu');
        }

        $filename = "rekapitulasi-penjualan-{$tanggalAwal}-sampai-{$tanggalAkhir}.xlsx";
        return Excel::download(new RekapPenjualanExport($request), $filename);
    }

    // Ambil data penjualan berdasarkan filter tanggal DAN simpan ke database
    private function getFilteredDataAndSave(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Cek apakah rekap untuk periode ini sudah ada
        $existingRekap = RekapPenjualan::where('rentang_tanggal_awal', $tanggalAwal)
                                      ->where('rentang_tanggal_akhir', $tanggalAkhir)
                                      ->exists();

        // Ambil data penjualan dari PesananItem
        $penjualanItems = PesananItem::with(['produk', 'pesanan'])
            ->whereHas('pesanan', function ($q) use ($tanggalAwal, $tanggalAkhir) {
                $q->whereBetween('waktu_pemesanan', [
                    Carbon::parse($tanggalAwal)->startOfDay(),
                    Carbon::parse($tanggalAkhir)->endOfDay()
                ])
                ->where('status', 'Selesai');
            })
            ->orderBy('id_pesanan', 'desc')
            ->get();

        $grandTotal = $penjualanItems->sum(function ($item) {
            return $item->harga_satuan * $item->jumlah;
        });

        // Jika belum ada rekap dan ada data penjualan, simpan ke database
        if (!$existingRekap && $penjualanItems->count() > 0) {
            RekapPenjualan::create([
                'id_pesanan' => $penjualanItems->first()->id_pesanan,
                'rentang_tanggal_awal' => $tanggalAwal,
                'rentang_tanggal_akhir' => $tanggalAkhir,
            ]);
        }

        return [
            'data' => $penjualanItems,
            'grand_total' => $grandTotal,
            'total_transaksi' => $penjualanItems->count(),
            'total_quantity' => $penjualanItems->sum('jumlah')
        ];
    }
}