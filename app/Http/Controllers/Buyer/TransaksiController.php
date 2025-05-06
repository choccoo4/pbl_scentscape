<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function transaksi()
    {
        return view('buyer.transaksi');
    }
}
