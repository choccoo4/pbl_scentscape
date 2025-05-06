<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk; // Pastikan model Produk sudah ada
use Illuminate\Support\Facades\Validator;

class TambahprodukController extends Controller
{
    // Menampilkan form untuk tambah produk
    public function create()
    {
        return view('sellers.tambahproduk'); // Pastikan view tambahproduk.blade.php ada
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menangani upload gambar (jika ada)
        $imagePath = null;
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('produk_images', 'public');
        }

        // Menyimpan data produk ke database
        $produk = new Produk();
        $produk->nama_produk = $request->input('nama_produk');
        $produk->deskripsi = $request->input('deskripsi');
        $produk->harga = $request->input('harga');
        $produk->stok = $request->input('stok');
        $produk->gambar = $imagePath;
        $produk->save();

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}
