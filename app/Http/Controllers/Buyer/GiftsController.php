<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Helpers\ProductCardFormatter;

class GiftsController extends Controller
{
    public function gifts(Request $request)
    {
        $products = Produk::with('aroma.aromaKategori')
            ->where('is_gifts', true)
            ->latest('waktu_dibuat')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($product) => ProductCardFormatter::from($product));

        return view('buyer.gifts', compact('products'));
    }
}
