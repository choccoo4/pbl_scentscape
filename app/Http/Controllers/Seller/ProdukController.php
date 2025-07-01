<?php
// app/Http/Controllers/Seller/ProdukController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Produk;
use App\Models\Aroma;
use App\Models\AromaKategori;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('nama_produk', 'like', '%' . $request->keyword . '%');
        }

        $produk = $query->latest('waktu_dibuat')->paginate(10)->withQueryString();

        // Add 'penjualan' column for display in blade
        foreach ($produk as $item) {
            $item->penjualan = $item->totalPenjualan(); // from model
        }

        return view('sellers.daftar_produk', compact('produk'));
    }

    public function create()
    {
        $categories = Aroma::all()->pluck('nama');
        $tipeList = Produk::select('tipe_parfum')->distinct()->pluck('tipe_parfum')->toArray();
        $volumeList = Produk::select('volume')->distinct()->pluck('volume')->toArray();
        $labelKategoriList = ['Unisex', 'For Him', 'For Her', 'Gifts'];

        $kategoriList = AromaKategori::all(['id', 'nama']);
        return view('sellers.tambah_produk', compact('categories', 'tipeList', 'volumeList', 'labelKategoriList', 'kategoriList'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('gambar') && count($request->file('gambar')) > 4) {
            return back()->withInput()->withErrors([
                'gambar' => 'Maximum upload is 4 images.',
            ]);
        }

        $request->validate([
            'nama_produk' => ['required', 'string', 'max:255', Rule::unique('produk', 'nama_produk')],
            'deskripsi' => 'required|string',
            'label_kategori' => 'required|in:Unisex,For Him,For Her',
            'is_gifts' => 'nullable|boolean',
            'tipe_parfum' => 'required|string|max:50',
            'volume' => 'required|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'required|array|min:1|max:4',
            'gambar.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'string'
        ], [
            'nama_produk.required' => 'Product name is required',
            'nama_produk.unique' => 'Product name already exists',
            'deskripsi.required' => 'Product description is required',
            'label_kategori.required' => 'Category label is required',
            'label_kategori.in' => 'Invalid category label',
            'tipe_parfum.required' => 'Perfume type is required',
            'tipe_parfum.max' => 'Perfume type max 50 characters',
            'volume.required' => 'Volume is required',
            'volume.max' => 'Volume max 20 characters',
            'harga.required' => 'Price is required',
            'harga.numeric' => 'Price must be numeric',
            'harga.min' => 'Price cannot be negative',
            'stok.required' => 'Stock is required',
            'stok.integer' => 'Stock must be an integer',
            'stok.min' => 'Stock cannot be negative',
            'gambar.required' => 'Product images must be uploaded at least one',
            'gambar.array' => 'Invalid image upload format',
            'gambar.min' => 'Upload at least 1 image',
            'gambar.max' => 'Maximum upload is 4 images',
            'gambar.*.image' => 'Each file must be an image',
            'gambar.*.mimes' => 'Image must be in jpg, jpeg, or png format',
            'gambar.*' => 'Image size must not exceed 2MB',
            'categories.required' => 'Select at least one scent',
            'categories.*.string' => 'Invalid scent format'
        ]);

        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                if ($index >= 4) break;
                $slug = Str::slug(Str::words($request->nama_produk, 1, ''));
                $filename = $slug . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('produk', $filename, 'public');

                if (!$path) {
                    return back()->with('error', 'Image upload failed!');
                }

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
            'is_gifts' => $request->boolean('is_gifts'),
            'tipe_parfum' => $request->tipe_parfum,
            'gambar' => $gambarPaths,
            'waktu_dibuat' => now(),
            'waktu_diperbarui' => now(),
        ]);

        if ($request->has('categories')) {
            $aromaIds = Aroma::whereIn('nama', $request->categories)->pluck('id_kategori');
            $produk->aroma()->attach($aromaIds);
        }
        return redirect()->route('produk.index')->with('success', 'Product added successfully.');
    }

    public function destroy($no_produk)
    {
        $produk = Produk::where('no_produk', $no_produk)->firstOrFail();

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Product deleted successfully');
    }

    public function edit($no_produk)
    {
        $produk = Produk::where('no_produk', $no_produk)->firstOrFail();
        $categories = Aroma::all()->pluck('nama');
        $tipeList = Produk::select('tipe_parfum')->distinct()->pluck('tipe_parfum')->toArray();
        $volumeList = Produk::select('volume')->distinct()->pluck('volume')->toArray();
        $labelKategoriList = ['Unisex', 'For Him', 'For Her'];
        $produkCategories = $produk->aroma()->pluck('nama')->toArray();
        $kategoriList = AromaKategori::all(['id', 'nama']);

        return view('sellers.update_produk', compact(
            'produk',
            'produkCategories',
            'categories',
            'tipeList',
            'volumeList',
            'labelKategoriList',
            'kategoriList'
        ));
    }

    public function update(Request $request, $no_produk)
    {
        $produk = Produk::where('no_produk', $no_produk)->firstOrFail();

        $existingGambar = [];
        if ($request->filled('existing_gambar')) {
            $existingGambar = json_decode($request->existing_gambar, true);
            if (!is_array($existingGambar)) {
                $existingGambar = [];
            }
        }

        $newImages = $request->file('gambar') ?? [];
        $totalImages = count($existingGambar) + count($newImages);
        if ($totalImages > 4) {
            return back()->withInput()->withErrors([
                'gambar' => 'Total images (existing + new) cannot exceed 4.'
            ]);
        }

        $validated = $request->validate([
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produk', 'nama_produk')->ignore($produk->no_produk, 'no_produk')
            ],
            'deskripsi' => 'required|string',
            'label_kategori' => 'required|in:Unisex,For Him,For Her',
            'is_gifts' => 'nullable|boolean',
            'tipe_parfum' => 'required|string|max:50',
            'volume' => 'required|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|array',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'string',
            'existing_gambar' => 'nullable|string',
        ], [
            'gambar.max' => 'Maximum 4 images.',
            'gambar.*.image' => 'Each file must be an image.',
            'gambar.*.mimes' => 'Image must be in jpg, jpeg, or png format.',
            'gambar.*.max' => 'Maximum image size is 2MB.',
            'categories.required' => 'Select at least one scent.',
        ]);

        $produk->update([
            'nama_produk' => $validated['nama_produk'],
            'deskripsi' => $validated['deskripsi'],
            'label_kategori' => $validated['label_kategori'],
            'is_gifts' => $request->boolean('is_gifts'),
            'tipe_parfum' => $validated['tipe_parfum'],
            'volume' => $validated['volume'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
        ]);

        $newGambarPaths = [];
        if (!empty($newImages)) {
            foreach ($newImages as $img) {
                $slug = Str::slug(Str::words($validated['nama_produk'], 1, ''));
                $filename = $slug . '-' . Str::random(6) . '.' . $img->getClientOriginalExtension();
                $img->storeAs('produk', $filename, 'public');
                $newGambarPaths[] = 'produk/' . $filename;
            }
        }

        $gambarSebelumnya = $produk->gambar ?? [];
        foreach ($gambarSebelumnya as $lama) {
            if (!in_array($lama, $existingGambar)) {
                Storage::disk('public')->delete($lama);
            }
        }

        $finalGambar = array_merge($existingGambar, $newGambarPaths);
        $produk->update([
            'gambar' => $finalGambar,
        ]);

        $aromaIds = Aroma::whereIn('nama', $validated['categories'])->pluck('id_kategori');
        $produk->aroma()->sync($aromaIds);

        return redirect()->route('produk.index')->with('success', 'Product updated successfully.');
    }
}
