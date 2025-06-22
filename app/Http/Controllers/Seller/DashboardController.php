<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        // Total penjualan hari ini (dari pesanan selesai)
        $totalPenjualan = Pesanan::where('status', 'Terkirim')
            ->whereDate('pesanan.waktu_pemesanan', now()->toDateString())
            ->sum('total');

        // Pesanan masuk hari ini (status awal)
        $pesananMasuk = Pesanan::whereDate('waktu_pemesanan', now()->toDateString())
            ->whereIn('status', ['Menunggu Verifikasi', 'Dikemas', 'Dikirim', 'Terkirim'])
            ->count();

        $produkTerjual = PesananItem::join('pesanan', 'pesanan_item.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('pesanan.status', 'Terkirim')
            ->whereDate('pesanan.waktu_pemesanan', now()->toDateString())
            ->sum('pesanan_item.jumlah');

        // Total stok semua produk
        $totalStokProduk = Produk::sum('stok');

        // Pesanan baru hari ini (status awal)
        $pesananBaruHariIni = Pesanan::whereDate('waktu_pemesanan', now()->toDateString())
            ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Verifikasi'])
            ->count();

        // Pesanan dikirim hari ini
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
}
