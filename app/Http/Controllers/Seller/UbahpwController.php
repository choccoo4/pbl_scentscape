<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class UbahpwController extends Controller
{
    public function ubahpw()
    {
        return view('sellers.changePassword'); // pastikan file view ini ada
    }
}
