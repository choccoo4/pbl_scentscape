<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Produk;


class DaftarprodukController extends Controller
{
    public function index()
    {
        $produk = Produk::paginate(5); // pagination 5 per halaman
        return view('sellers.daftarproduk', compact('produk'));
    }

    public function create()
    {
        return view('sellers.tambahproduk');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('sellers.updateproduk', compact('produk'));
    }
}
