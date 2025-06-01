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


class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::latest('waktu_dibuat')->paginate(10);
        return view('sellers.daftarproduk', compact('produk'));
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
        if ($request->hasFile('gambar') && count($request->file('gambar')) > 4) {
            return back()->withInput()->withErrors([
                'gambar' => 'Maksimal upload 4 gambar saja.',
            ]);
        }

        $request->validate([
            'nama_produk' => ['required', 'string', 'max:255', Rule::unique('produk', 'nama_produk')],
            'deskripsi' => 'required|string',
            'label_kategori' => 'required|in:Unisex,For Him,For Her,Gifts',
            'tipe_parfum' => 'required|string|max:50',
            'volume' => 'required|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'required|array|min:1|max:4',
            'gambar.*' => 'required|image|mimes:jpg,jpeg,png|max:2048', // kalau mau pakai 2MB
            'categories' => 'required|array|min:1',
            'categories.*' => 'string'
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'nama_produk.unique' => 'Nama produk sudah digunakan',
            'deskripsi.required' => 'Deskripsi produk harus diisi',
            'label_kategori.required' => 'Label kategori wajib dipilih',
            'label_kategori.in' => 'Label kategori tidak valid',
            'tipe_parfum.required' => 'Tipe parfum wajib diisi',
            'tipe_parfum.max' => 'Tipe parfum maksimal 50 karakter',
            'volume.required' => 'Volume wajib diisi',
            'volume.max' => 'Volume maksimal 20 karakter',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok wajib diisi',
            'stok.integer' => 'Stok harus berupa angka bulat',
            'stok.min' => 'Stok tidak boleh negatif',
            'gambar.required' => 'Foto produk wajib diupload minimal satu',
            'gambar.array' => 'Format upload gambar tidak valid',
            'gambar.min' => 'Upload minimal 1 gambar',
            'gambar.max' => 'Maksimal upload 4 gambar saja',
            'gambar.*.image' => 'File harus berupa gambar',
            'gambar.*.mimes' => 'Gambar harus berformat jpg, jpeg, atau png',
            'gambar.*' => 'Ukuran gambar maksimal 2MB',
            'categories.required' => 'Pilih minimal satu aroma',
            'categories.*.string' => 'Format aroma tidak valid'
        ]);

        // simpan gambar maksimal 4
        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                if ($index >= 4) break;
                $slug = Str::slug(Str::words($request->nama_produk, 1, ''));
                $filename = $slug . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('produk', $filename, 'public');

                if (!$path) {
                    // Upload gagal, bisa return response gagal
                    return back()->with('error', 'Upload gambar gagal!');
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

    public function destroy($no_produk)
    {
        $produk = Produk::where('no_produk', $no_produk)->firstOrFail();

        // Hapus file gambar jika perlu
        if ($produk->gambar && is_array($produk->gambar)) {
            foreach ($produk->gambar as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }

    public function edit($no_produk)
    {
        $produk = Produk::where('no_produk', $no_produk)->firstOrFail();
        $categories = Aroma::all()->pluck('nama');
        $tipeList = Produk::select('tipe_parfum')->distinct()->pluck('tipe_parfum')->toArray();
        $volumeList = Produk::select('volume')->distinct()->pluck('volume')->toArray();
        $labelKategoriList = ['Unisex', 'For Him', 'For Her', 'Gifts'];
        $produkCategories = $produk->aroma()->pluck('nama')->toArray(); // ambil nama aroma yang sudah dipilih
        $categories = Aroma::all()->pluck('nama'); // semua aroma

        return view('sellers.updateproduk', compact(
            'produk',
            'produkCategories',
            'categories',
            'tipeList',
            'volumeList',
            'labelKategoriList'
        ));
    }

    public function update(Request $request, $no_produk)
    {
        $produk = Produk::where('no_produk', $no_produk)->firstOrFail();

        // Ambil array gambar lama yang dipertahankan
        $existingGambar = [];
        if ($request->filled('existing_gambar')) {
            $existingGambar = json_decode($request->existing_gambar, true);
            if (!is_array($existingGambar)) {
                $existingGambar = [];
            }
        }

        // Cek total gambar tidak boleh lebih dari 4
        $newImages = $request->file('gambar') ?? [];
        $totalImages = count($existingGambar) + count($newImages);
        if ($totalImages > 4) {
            return back()->withInput()->withErrors([
                'gambar' => 'Total gambar (lama + baru) tidak boleh lebih dari 4.'
            ]);
        }

        // Validasi data
        $validated = $request->validate([
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produk', 'nama_produk')->ignore($produk->no_produk, 'no_produk')
            ],
            'deskripsi' => 'required|string',
            'label_kategori' => 'required|in:Unisex,For Him,For Her,Gifts',
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
            'gambar.max' => 'Maksimal 4 gambar.',
            'gambar.*.image' => 'Setiap file harus berupa gambar.',
            'gambar.*.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar.*.max' => 'Ukuran gambar maksimal 2MB.',
            'categories.required' => 'Minimal satu aroma harus dipilih.',
        ]);

        // Update kolom utama produk
        $produk->update([
            'nama_produk' => $validated['nama_produk'],
            'deskripsi' => $validated['deskripsi'],
            'label_kategori' => $validated['label_kategori'],
            'tipe_parfum' => $validated['tipe_parfum'],
            'volume' => $validated['volume'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
        ]);

        // Upload gambar baru
        $newGambarPaths = [];
        if (!empty($newImages)) {
            foreach ($newImages as $img) {
                $slug = Str::slug(Str::words($validated['nama_produk'], 1, ''));
                $filename = $slug . '-' . Str::random(6) . '.' . $img->getClientOriginalExtension();
                $img->storeAs('produk', $filename, 'public');
                $newGambarPaths[] = 'produk/' . $filename;
            }
        }

        // Opsional: hapus gambar lama yang tidak dipertahankan
        $gambarSebelumnya = $produk->gambar ?? [];
        foreach ($gambarSebelumnya as $lama) {
            if (!in_array($lama, $existingGambar)) {
                Storage::disk('public')->delete($lama);
            }
        }

        // Gabungkan gambar lama + baru lalu update
        $finalGambar = array_merge($existingGambar, $newGambarPaths);
        $produk->update([
            'gambar' => $finalGambar, // otomatis disimpan sebagai JSON
        ]);

        // Update relasi aroma
        $aromaIds = Aroma::whereIn('nama', $validated['categories'])->pluck('id_kategori');
        $produk->aroma()->sync($aromaIds);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }
}
