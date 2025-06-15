<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\PesananItem;
use App\Helpers\ProductCardFormatter;

class BestSellersController extends Controller
{
    public function bestSellers()
    {
        // Ambil produk yang pernah dibeli, urutkan berdasarkan total terjual
        $bestsellerProduk = PesananItem::select('no_produk', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('no_produk')
            ->orderByDesc('total_terjual')
            ->take(8)
            ->pluck('no_produk');

        // Cek apakah ada data bestseller
        if ($bestsellerProduk->count() > 0) {
            // Ambil data produk dari ID bestseller
            $products = Produk::with('aroma.aromaKategori')
                ->whereIn('no_produk', $bestsellerProduk)
                ->get()
                ->map(fn($product) => ProductCardFormatter::from($product));
        } else {
            // Kalau belum ada penjualan, fallback ke produk terbaru
            $products = Produk::with('aroma.aromaKategori')
                ->latest('waktu_dibuat')
                ->take(8)
                ->get()
                ->map(fn($product) => ProductCardFormatter::from($product));
        }

        return view('buyer.best-sellers', compact('products'));
    }
}
