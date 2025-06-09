<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Helpers\ProductCardFormatter;

class GiftsController extends Controller
{
    public function gifts()
    {
        $products = Produk::with('aroma.aromaKategori')
            ->where('label_kategori', 'Gifts')
            ->latest('waktu_dibuat')
            ->get()
            ->map(fn($product) => ProductCardFormatter::from($product));

        return view('buyer.gifts', compact('products'));
    }
}
