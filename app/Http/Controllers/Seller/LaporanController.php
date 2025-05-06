<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        return view('sellers.laporan'); // halaman laporan
    }
}
