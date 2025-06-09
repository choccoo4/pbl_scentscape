<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Helpers\ProductCardFormatter;

class ShopController extends Controller
{
    public function shop()
    {
        $products = Produk::with('aroma.aromaKategori')
            ->latest('waktu_dibuat')
            ->get()
            ->map(fn($product) => ProductCardFormatter::from($product));

        return view('buyer.shop', compact('products'));
    }
}
