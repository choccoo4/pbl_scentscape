<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class DaftarprodukController extends Controller
{
    public function index()
    {
        return view('sellers.daftarproduk');
    }

    public function create()
    {
        return view('sellers.tambahproduk');
    }

    public function edit()
    {
        return view('sellers.updateproduk');
    }
}
