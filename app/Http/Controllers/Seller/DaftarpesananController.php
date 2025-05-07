<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarpesananController extends Controller
{
    public function daftarPesanan()
    {
        return view('sellers.daftarpesanan');
    }
}
