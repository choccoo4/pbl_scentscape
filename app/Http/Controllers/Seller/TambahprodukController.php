<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Aroma;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TambahprodukController extends Controller
{
    public function create()
    {
        // Kirim daftar aroma dan kategori ke view
        $categories = Aroma::pluck('nama')->toArray();
        $kategoriList = Aroma::select('id', 'kategori')->distinct()->get()->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'nama' => $item->kategori
            ];
        });

        $labelKategoriList = ['Unisex', 'For Him', 'For Her', 'Gifts'];

        return view('seller.produk.create', compact('categories', 'kategoriList', 'labelKategoriList'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_produk'     => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'label_kategori'  => 'required|string',
            'tipe_parfum'     => 'required|string',
            'volume'          => 'required|string|max:20',
            'harga'           => 'required|numeric|min:0',
            'stok'            => 'required|integer|min:0',
            'categories'      => 'required|array|min:1',
            'gambar.*'        => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'categories.required' => 'At least one scent category must be selected.',
            'gambar.*.image' => 'All files must be valid images.',
            'gambar.*.max' => 'Each image must not exceed 2MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Simpan produk
        $produk = new Produk();
        $produk->id_penjual     = Auth::user()->penjual->id_penjual;
        $produk->nama_produk    = $request->nama_produk;
        $produk->deskripsi      = $request->deskripsi;
        $produk->label_kategori = $request->label_kategori;
        $produk->tipe_parfum    = $request->tipe_parfum;
        $produk->volume         = $request->volume;
        $produk->harga          = $request->harga;
        $produk->stok           = $request->stok;
        $produk->save();

        // Simpan aroma (relasi many to many jika ada pivot table produk_aroma)
        if ($request->has('categories')) {
            $aromaIds = Aroma::whereIn('nama', $request->categories)->pluck('id')->toArray();
            $produk->aromas()->sync($aromaIds);
        }

        // Simpan gambar
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('produk_images', 'public');
                $produk->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('produk.index')->with('success', 'Product has been added successfully.');
    }
}
