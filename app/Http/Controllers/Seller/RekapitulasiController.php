<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    public function rekapitulasi()
    {
        return view('sellers.rekapitulasi');
    }
}
