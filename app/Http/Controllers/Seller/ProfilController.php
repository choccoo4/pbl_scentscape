<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function index()
    {
        return view('sellers.profil-penjual');
    }

    public function ubahpw()
    {
        return view('sellers.ubahpw');
    }
}
