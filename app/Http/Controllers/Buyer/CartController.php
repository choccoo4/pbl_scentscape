<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $user = Auth::user();
        $keranjang = Keranjang::where('id_pengguna', $user->id_pengguna)->first();

        $items = collect();
        if ($keranjang) {
            $items = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
                ->with(['produk' => function($query) {
                    $query->select('no_produk', 'nama_produk', 'harga', 'gambar', 'stok');
                }])
                ->get();
        }

        $cartItems = $items->map(function($item) {
            $gambar = $item->produk->gambar;
            if (is_array($gambar)) {
                $gambarUtama = $gambar[0] ?? 'default.jpg';
            } else {
                $gambarUtama = $gambar ?: 'default.jpg';
            }

            return [
                'no_produk' => $item->no_produk,
                'name' => $item->produk->nama_produk,
                'price' => $item->produk->harga,
                'quantity' => $item->jumlah_produk,
                // Perbaikan: buat URL lengkap gambar sesuai folder public/images/products
                'img' => asset('images/products/' . $gambarUtama),
                'stock' => $item->produk->stok,
                'total' => $item->produk->harga * $item->jumlah_produk,
            ];
        });

        $grandTotal = $cartItems->sum('total');

        return view('buyer.cart', compact('cartItems', 'grandTotal'));
    }

    // Tambah produk ke keranjang - UPDATED
    public function add(Request $request, $no_produk)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $user = Auth::user();
        $produk = Produk::findOrFail($no_produk);

        $quantity = $request->input('quantity', 1);

        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Produk tidak tersedia!');
        }

        if ($quantity > $produk->stok) {
            return redirect()->back()->with('error', 'Jumlah produk melebihi stok yang tersedia!');
        }

        DB::beginTransaction();

        try {
            $keranjang = Keranjang::firstOrCreate([
                'id_pengguna' => $user->id_pengguna,
            ], [
                'waktu_ditambahkan' => now()
            ]);

            $item = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
                ->where('no_produk', $produk->no_produk)
                ->first();

            if ($item) {
                $totalQuantity = $item->jumlah_produk + $quantity;
                if ($totalQuantity > $produk->stok) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Total jumlah produk melebihi stok yang tersedia!');
                }
                $item->jumlah_produk = $totalQuantity;
                $item->save();
            } else {
                KeranjangItem::create([
                    'id_keranjang' => $keranjang->id_keranjang,
                    'no_produk' => $produk->no_produk,
                    'jumlah_produk' => $quantity,
                ]);
            }

            DB::commit();

            $message = $quantity > 1 
                ? "Berhasil menambahkan {$quantity} produk ke keranjang!" 
                : 'Produk berhasil ditambahkan ke keranjang!';

            return redirect()->route('cart')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding to cart: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan produk ke keranjang!');
        }
    }

    // Update jumlah produk di keranjang
    public function update(Request $request, $no_produk)
    {
        $request->validate([
            'jumlah_produk' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $keranjang = Keranjang::where('id_pengguna', $user->id_pengguna)->first();

        if (!$keranjang) {
            return response()->json(['message' => 'Keranjang tidak ditemukan!'], 404);
        }

        $item = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
            ->where('no_produk', $no_produk)
            ->with('produk')
            ->first();

        if (!$item) {
            return response()->json(['message' => 'Produk tidak ditemukan di keranjang!'], 404);
        }

        $jumlahBaru = $request->input('jumlah_produk');

        if ($jumlahBaru > $item->produk->stok) {
            return response()->json(['message' => 'Jumlah melebihi stok yang tersedia!'], 400);
        }

        $item->update(['jumlah_produk' => $jumlahBaru]);

        return response()->json(['message' => 'Jumlah produk berhasil diperbarui!'], 200);
    }

    // Hapus produk dari keranjang
    public function remove(Request $request, $no_produk)
    {
        $user = Auth::user();
        $keranjang = Keranjang::where('id_pengguna', $user->id_pengguna)->first();

        if (!$keranjang) {
            return redirect()->route('cart')->with('error', 'Keranjang tidak ditemukan!');
        }

        $item = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
            ->where('no_produk', $no_produk)
            ->first();

        if ($item) {
            $item->delete();
            return redirect()->route('cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
        }

        return redirect()->route('cart')->with('error', 'Produk tidak ditemukan di keranjang!');
    }
}
