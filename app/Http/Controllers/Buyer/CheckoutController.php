<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Pembeli;
use App\Models\Keranjang;
use App\Models\KeranjangItem;

class CheckoutController extends Controller
{
    // Ini untuk handle POST dari halaman cart
    public function handleCheckout(Request $request)
    {
        $items = json_decode($request->input('selected_items'), true);

        // Tambahkan ini untuk cek isi

        if (!$items || !is_array($items)) {
            return back()->with('error', 'Kamu belum pilih item apa pun untuk checkout!');
        }

        session(['checkout_items' => $items]);

        return redirect()->route('checkout.page');
    }

    // Ini untuk render halaman checkout (GET)
    public function checkout()
    {
        $authId = Auth::id();
        $pembeli = Pembeli::with('pengguna')->where('id_pengguna', $authId)->first();

        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return redirect()->route('cart')->with('error', 'Tidak ada produk yang dipilih untuk checkout.');
        }

        // Ambil produk dari database
        $produkIds = collect($checkoutItems)->pluck('id')->toArray();
        $produkList = Produk::whereIn('no_produk', $produkIds)->get();

        // Tambahkan qty ke setiap produk
        foreach ($produkList as $produk) {
            $matched = collect($checkoutItems)->firstWhere('id', $produk->no_produk);
            $produk->qty = $matched['qty'] ?? 1;

            $gambarArray = $produk->gambar;
            $produk->gambar_utama = is_array($produk->gambar) ? $produk->gambar[0] : $produk->gambar;
        }

        // Hitung subtotal dan total
        $subtotal = $produkList->sum(fn($p) => $p->harga * $p->qty);
        $shipping = 32000;
        $total = $subtotal + $shipping;
        $parts = explode('|', $pembeli->alamat);
        $parsedAlamat = [
            'address' => trim($parts[0] ?? ''),
            'city' => trim($parts[1] ?? ''),
            'province' => trim($parts[2] ?? ''),
            'postal_code' => trim($parts[3] ?? ''),
        ];

        if ($pembeli && $pembeli->alamat) {
            $parts = explode('|', $pembeli->alamat);
            $parsedAlamat['address'] = trim($parts[0] ?? '');
            $parsedAlamat['city'] = trim($parts[1] ?? '');
            $parsedAlamat['province'] = trim($parts[2] ?? '');
            $parsedAlamat['postal_code'] = trim($parts[3] ?? '');
        }

        return view('buyer.checkout', compact('produkList', 'subtotal', 'shipping', 'total', 'pembeli', 'parsedAlamat'));
    }

    public function processCheckout(Request $request)
    {
        $authId = Auth::id();
        $pembeli = Pembeli::where('id_pengguna', $authId)->firstOrFail();

        $request->validate([
            'full_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
        ]);

        // Gabungkan dengan |
        $fullAlamat = "{$request->address} | {$request->city} | {$request->province} | {$request->postal_code}";

        Pembeli::updateOrCreate(
            ['id_pengguna' => $authId],
            ['alamat' => $fullAlamat, 'no_telp' => $request->phone]
        );

        $checkoutItems = session('checkout_items', []);
        if (empty($checkoutItems)) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong.');
        }

        // Ambil data produk
        $produkIds = collect($checkoutItems)->pluck('id')->toArray();
        $produkList = \App\Models\Produk::whereIn('no_produk', $produkIds)->get();

        // Hitung total
        $subtotal = $produkList->sum(function ($produk) use ($checkoutItems) {
            $item = collect($checkoutItems)->firstWhere('id', $produk->no_produk);
            return $produk->harga * ($item['qty'] ?? 1);
        });

        $ongkir = 32000;
        $total = $subtotal + $ongkir;

        // Simpan ke tabel pesanan
        $now = Carbon::now();
        $nomorPesanan = 'INV-SCENT-' . $now->format('Ymd') . '-' . strtoupper(Str::random(5));
        $batasBayar = $now->copy()->addHour();

        $pesanan = Pesanan::create([
            'id_pengguna' => $authId,
            'nomor_pesanan' => $nomorPesanan,
            'total' => $total,
            'ongkir' => $ongkir,
            'status' => 'Menunggu Pembayaran',
            'batas_waktu_pembayaran' => $batasBayar,
        ]);

        // Simpan ke pesanan_item
        foreach ($produkList as $produk) {
            $item = collect($checkoutItems)->firstWhere('id', $produk->no_produk);
            $qty = $item['qty'] ?? 1;
            PesananItem::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'no_produk' => $produk->no_produk,
                'jumlah' => $qty,
                'nama_produk' => $produk->nama_produk,
                'gambar_produk' => is_array($produk->gambar) ? $produk->gambar[0] : $produk->gambar,
                'harga_satuan' => $produk->harga,
                'subtotal' => $produk->harga * $qty,
            ]);
        }

        // Simpan ID pesanan ke session biar bisa diambil di halaman transaksi
        session(['pesanan_id' => $pesanan->id_pesanan]);

        // Hapus item yang sudah di-checkout dari keranjang
        $keranjang = Keranjang::where('id_pengguna', $authId)->first();

        if ($keranjang) {
            foreach ($checkoutItems as $item) {
                KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
                    ->where('no_produk', $item['id'])
                    ->delete();
            }
        }
        session()->forget('checkout_items');
        return redirect()->route('transaksi');
    }
}
