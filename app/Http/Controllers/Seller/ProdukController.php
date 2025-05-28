<?php
// app/Http/Controllers/Seller/ProdukController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Aroma;


class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::latest('waktu_dibuat')->get();
        return view('sellers.daftarproduk.index', compact('produk'));
    }

    public function create()
    {
        $categories = Aroma::all()->pluck('nama');  // ambil kolom 'nama' aja sebagai array
        $tipeList = Produk::select('tipe_parfum')->distinct()->pluck('tipe_parfum')->toArray();
        $volumeList = Produk::select('volume')->distinct()->pluck('volume')->toArray();
        $labelKategoriList = ['Unisex', 'For Him', 'For Her', 'Gifts'];

        return view('sellers.tambahproduk', compact('categories', 'tipeList', 'volumeList', 'labelKategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'volume' => 'required|string|max:20',
            'label_kategori' => 'required|in:Unisex,For Him,For Her,Gifts',
            'tipe_parfum' => 'required|string|max:50',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // simpan gambar maksimal 4
        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                if ($index >= 4) break;
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/produk', $filename);
                $gambarPaths[] = 'produk/' . $filename;
            }
        }

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'volume' => $request->volume,
            'label_kategori' => $request->label_kategori,
            'tipe_parfum' => $request->tipe_parfum,
            'gambar' => $gambarPaths,
            'waktu_dibuat' => now(),
            'waktu_diperbarui' => now(),
        ]);

        if ($request->has('categories')) {
            $aromaIds = Aroma::whereIn('nama', $request->categories)->pluck('id_kategori');
            $produk->aroma()->attach($aromaIds);
        }
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        // kalau kamu simpan gambar di storage, hapus filenya juga di sini

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
