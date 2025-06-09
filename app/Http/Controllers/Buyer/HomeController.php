<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ProductCardFormatter;
use App\Models\Produk;
use App\Models\AromaKategori;

class HomeController extends Controller
{
    public function home()
    {
        $products = Produk::with('aroma.aromaKategori')
            ->latest('waktu_dibuat')
            ->take(4)
            ->get()
            ->map(fn($product) => ProductCardFormatter::from($product));

        $ingredients = AromaKategori::take(12)->get()->map(function ($item) {
            return [
                'name' => $item->nama,
                'img' => $item->gambar ?? 'default.jpg',
            ];
        });

        return view('buyer.home', compact('products', 'ingredients'));
    }
}
