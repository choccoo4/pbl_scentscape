<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ProductCardFormatter;
use App\Models\Produk;
use App\Models\AromaKategori;
use App\Models\PesananItem;

class HomeController extends Controller
{
    public function home()
    {
        // Produk terbaru
        $products = Produk::with('aroma.aromaKategori')
            ->latest('waktu_dibuat')
            ->take(4)
            ->get()
            ->map(fn($product) => ProductCardFormatter::from($product));

        // Ingredients (aroma kategori)
        $ingredients = AromaKategori::take(12)->get()->map(function ($item) {
            return [
                'name' => $item->nama,
                'img' => $item->gambar ?? 'default.jpg',
            ];
        });

        // Best Sellers (atau fallback produk terbaru)
        $bestsellerProduk = PesananItem::select('no_produk', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('no_produk')
            ->orderByDesc('total_terjual')
            ->take(2)
            ->pluck('no_produk');

        if ($bestsellerProduk->count() > 0) {
            $bestSellers = Produk::with('aroma.aromaKategori')
                ->whereIn('no_produk', $bestsellerProduk)
                ->get()
                ->map(fn($product) => ProductCardFormatter::from($product));
        } else {
            $bestSellers = Produk::with('aroma.aromaKategori')
                ->latest('waktu_dibuat')
                ->take(2)
                ->get()
                ->map(fn($product) => ProductCardFormatter::from($product));
        }

        return view('buyer.home', compact('products', 'ingredients', 'bestSellers'));
    }
}
