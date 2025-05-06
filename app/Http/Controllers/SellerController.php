<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard()
    {
        return view('sellers.dashboard');
    }

    public function daftarProduk()
    {
        return view('sellers.daftarproduk');
    }

    public function tambahProduk()
    {
        return view('sellers.tambahproduk');
    }

    public function updateProduk()
    {
        return view('sellers.updateproduk');
    }

    public function daftarPesanan()
    {
        return view('sellers.daftarpesanan');
    }

    public function rekapitulasi()
    {
        return view('sellers.rekapitulasi');
    }

    public function laporan()
    {
        return view('sellers.laporan');
    }

    public function profilPenjual()
    {
        return view('sellers.profile');
    }

    public function ubahPasswordPenjual()
    {
        return view('sellers.change-pw');
    }

}

