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
        return view('sellers.daftar_produk');
    }

    public function tambahProduk()
    {
        return view('sellers.tambah_produk');
    }

    public function updateProduk()
    {
        return view('sellers.update_produk');
    }

    public function daftarPesanan()
    {
        return view('sellers.daftar_pesanan');
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
        return view('sellers.profil_penjual');
    }

    public function ubahPasswordPenjual()
    {
        return view('sellers.change-pw');
    }

}

