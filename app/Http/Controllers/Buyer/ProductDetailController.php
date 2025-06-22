<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProductDetailController extends Controller
{
    public function productDetail($id)
    {
        $product = Produk::with('aroma')->findOrFail($id);

        return view('buyer.product_detail', compact('product'));
    }
}
