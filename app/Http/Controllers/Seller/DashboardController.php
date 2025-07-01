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
        // Total sales today (completed orders)
        $totalPenjualan = Pesanan::where('status', 'Terkirim')
            ->whereDate('pesanan.waktu_pemesanan', now()->toDateString())
            ->sum('total');

        // Incoming orders today (pending or in process)
        $pesananMasuk = Pesanan::whereDate('waktu_pemesanan', now()->toDateString())
            ->whereIn('status', ['Menunggu Verifikasi', 'Dikemas', 'Dikirim', 'Terkirim'])
            ->count();

        // Products sold today
        $produkTerjual = PesananItem::join('pesanan', 'pesanan_item.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('pesanan.status', 'Terkirim')
            ->whereDate('pesanan.waktu_pemesanan', now()->toDateString())
            ->sum('pesanan_item.jumlah');

        // Total stock of all products
        $totalStokProduk = Produk::sum('stok');

        // New orders today (not yet paid or verified)
        $pesananBaruHariIni = Pesanan::whereDate('waktu_pemesanan', now()->toDateString())
            ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Verifikasi'])
            ->count();

        // Products shipped today
        $produkTerkirimHariIni = PesananItem::join('pesanan', 'pesanan_item.id_pesanan', '=', 'pesanan.id_pesanan')
            ->whereDate('pesanan.waktu_pemesanan', now()->toDateString())
            ->whereIn('pesanan.status', ['Dikirim', 'Terkirim'])
            ->sum('pesanan_item.jumlah');

        return view('sellers.dashboard', compact(
            'totalPenjualan',
            'pesananMasuk',
            'produkTerjual',
            'totalStokProduk',
            'pesananBaruHariIni',
            'produkTerkirimHariIni'
        ));
    }

    /**
     * API endpoint for weekly sales chart data
     * Fetch completed orders in the last 7 days
     */
    public function getWeeklySales()
    {
        try {
            // Get last 7 days including today
            $dates = collect();
            for ($i = 6; $i >= 0; $i--) {
                $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
            }

            // Query daily sales in the last 7 days
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

            // Prepare data for chart
            $labels = [];
            $salesAmounts = [];
            $orderCounts = [];

            // English day names, indexed by Carbon::dayOfWeek (0=Sunday, 6=Saturday)
            $dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            foreach ($dates as $date) {
                $carbonDate = Carbon::parse($date);
                $dayName = $dayNames[$carbonDate->dayOfWeek];
                $labels[] = $dayName;

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
                        'mulai' => Carbon::now()->subDays(6)->locale('en')->isoFormat('D MMMM YYYY'),
                        'selesai' => Carbon::now()->locale('en')->isoFormat('D MMMM YYYY')
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve weekly sales data',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error occurred'
            ], 500);
        }
    }
}
