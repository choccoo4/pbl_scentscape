<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function create()
    {
        $categories = ['Floral', 'Woody', 'Citrus', 'Oriental', 'Fresh'];

    return view('sellers.tambahproduk', compact('categories'));

    }
}
