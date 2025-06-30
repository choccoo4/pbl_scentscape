<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Status pesanan yang dianggap sukses (pembayaran sudah diverifikasi)
        $statusTerjual = ['Dikirim', 'Terkirim', 'Selesai'];

        // Total penjualan hari ini
        $totalPenjualan = Pesanan::whereIn('status', $statusTerjual)
            ->whereDate('waktu_pemesanan', now()->toDateString())
            ->sum('total');

        // Produk terjual hari ini
        $produkTerjual = PesananItem::join('pesanan', 'pesanan_item.id_pesanan', '=', 'pesanan.id_pesanan')
            ->whereIn('pesanan.status', $statusTerjual)
            ->whereDate('pesanan.waktu_pemesanan', now()->toDateString())
            ->sum('pesanan_item.jumlah');

        // Pesanan masuk hari ini
        $pesananMasuk = Pesanan::whereDate('waktu_pemesanan', now()->toDateString())
            ->whereIn('status', ['Menunggu Verifikasi', 'Dikemas', 'Dikirim', 'Terkirim'])
            ->count();

        // Pesanan baru hari ini
        $pesananBaruHariIni = Pesanan::whereDate('waktu_pemesanan', now()->toDateString())
            ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Verifikasi'])
            ->count();

        // Produk dikirim hari ini
        $produkTerkirimHariIni = PesananItem::join('pesanan', 'pesanan_item.id_pesanan', '=', 'pesanan.id_pesanan')
            ->whereIn('pesanan.status', ['Dikirim', 'Terkirim'])
            ->whereDate('pesanan.waktu_pemesanan', now()->toDateString())
            ->sum('pesanan_item.jumlah');

        // Total stok semua produk
        $totalStokProduk = Produk::sum('stok');

        return view('sellers.dashboard', compact(
            'totalPenjualan',
            'produkTerjual',
            'pesananMasuk',
            'pesananBaruHariIni',
            'produkTerkirimHariIni',
            'totalStokProduk'
        ));
    }

    /**
     * API endpoint untuk data chart penjualan mingguan
     * Ambil data pesanan selesai 7 hari terakhir
     */
    public function getWeeklySales()
    {
        try {
            // Ambil 7 hari terakhir termasuk hari ini
            $dates = collect();
            for ($i = 6; $i >= 0; $i--) {
                $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
            }

            // Query penjualan per hari dalam 7 hari terakhir
            $salesData = Pesanan::select(
                DB::raw('DATE(waktu_selesai) as tanggal'),
                DB::raw('COALESCE(SUM(total), 0) as total_penjualan'),
                DB::raw('COUNT(*) as jumlah_pesanan')
            )
                ->where('status', 'Selesai')
                ->whereDate('waktu_selesai', '>=', Carbon::now()->subDays(6)->format('Y-m-d'))
                ->whereDate('waktu_selesai', '<=', Carbon::now()->format('Y-m-d'))
                ->groupBy(DB::raw('DATE(waktu_selesai)'))
                ->get()
                ->keyBy('tanggal');

            // Siapkan data untuk chart
            $labels = [];
            $salesAmounts = [];
            $orderCounts = [];
            $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

            foreach ($dates as $date) {
                $carbonDate = Carbon::parse($date);
                $dayName = $dayNames[$carbonDate->dayOfWeek];
                $labels[] = $dayName;

                // Ambil data penjualan untuk tanggal ini, kalau tidak ada = 0
                if (isset($salesData[$date])) {
                    $salesAmounts[] = (float) $salesData[$date]->total_penjualan;
                    $orderCounts[] = (int) $salesData[$date]->jumlah_pesanan;
                } else {
                    $salesAmounts[] = 0;
                    $orderCounts[] = 0;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'labels' => $labels,
                    'sales' => $salesAmounts,
                    'orders' => $orderCounts,
                    'total_sales' => array_sum($salesAmounts),
                    'total_orders' => array_sum($orderCounts),
                    'periode' => [
                        'mulai' => Carbon::now()->subDays(6)->format('d M Y'),
                        'selesai' => Carbon::now()->format('d M Y')
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data penjualan mingguan',
                'error' => config('app.debug') ? $e->getMessage() : 'Terjadi kesalahan server'
            ], 500);
        }
    }
}
