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
                ->with(['produk' => function ($query) {
                    $query->select('no_produk', 'nama_produk', 'harga', 'gambar', 'stok');
                }])
                ->get();
        }

        $cartItems = $items->map(function ($item) {
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
                'img' => asset('storage/' . $gambarUtama),
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
            return $request->wantsJson()
                ? response()->json(['message' => 'Product is not available!'], 400)
                : redirect()->back()->with('error', 'Product is not available!');
        }

        if ($quantity > $produk->stok) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Quantity exceeds available stock!'], 400)
                : redirect()->back()->with('error', 'Quantity exceeds available stock!');
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
                    return $request->wantsJson()
                        ? response()->json(['message' => 'Total jumlah melebihi stok!'], 400)
                        : redirect()->back()->with('error', 'Total jumlah melebihi stok!');
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
                ? "Successfully added {$quantity} items to cart!"
                : 'Product has been added to your cart!';

            return $request->wantsJson()
                ? response()->json(['message' => $message], 200)
                : redirect()->route('cart')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding to cart: ' . $e->getMessage());
            return $request->wantsJson()
                ? response()->json(['message' => 'Failed to add product to cart!'], 500)
                : redirect()->back()->with('error', 'Failed to add product to cart!');
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
            return response()->json(['message' => 'Cart not found!'], 404);
        }

        $item = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
            ->where('no_produk', $no_produk)
            ->with('produk')
            ->first();

        if (!$item) {
            return response()->json(['message' => 'Product not found in cart!'], 404);
        }

        $jumlahBaru = $request->input('jumlah_produk');

        if ($jumlahBaru > $item->produk->stok) {
            return response()->json(['message' => 'Quantity exceeds available stock!'], 400);
        }

        $item->update(['jumlah_produk' => $jumlahBaru]);

        return response()->json(['message' => 'Product quantity updated successfully!'], 200);
    }

    // Hapus produk dari keranjang
    public function remove(Request $request, $no_produk)
    {
        $user = Auth::user();
        $keranjang = Keranjang::where('id_pengguna', $user->id_pengguna)->first();

        if (!$keranjang) {
            return redirect()->route('cart')->with('error', 'Cart not found!');
        }

        $item = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
            ->where('no_produk', $no_produk)
            ->first();

        if ($item) {
            $item->delete();
            return redirect()->route('cart')->with('success', 'Product has been removed from cart!');
        }

        return redirect()->route('cart')->with('error', 'Product not found in cart!');
    }
}
