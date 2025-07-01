<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\Pengiriman;

class DetailPesananController extends Controller
{
    public function show($id)
    {
        // Get order data
        $pesanan = Pesanan::with(['pengguna', 'items', 'pembayaran'])->findOrFail($id);

        return view('sellers.detail_pesanan', compact('pesanan'));
    }

    public function tolak($id)
    {
        $pesanan = Pesanan::with('items.produk')->findOrFail($id);

        if (!in_array($pesanan->status, ['Menunggu Verifikasi', 'Menunggu Pembayaran'])) {
            return back()->with('error', 'The order cannot be rejected at this status.');
        }

        // Return stock
        foreach ($pesanan->items as $item) {
            $produk = $item->produk;
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->save();
            }
        }

        // Update order status
        $pesanan->status = 'Ditolak';
        $pesanan->save();

        return back()->with('success', 'Order has been rejected and stock returned.');
    }

    public function konfirmasi($id)
    {
        $pesanan = Pesanan::with('items.produk')->findOrFail($id);

        if ($pesanan->status !== 'Menunggu Verifikasi') {
            return back()->with('error', 'The order is not in verification status.');
        }

        // Check stock availability
        foreach ($pesanan->items as $item) {
            $produk = $item->produk;
            if (!$produk || $produk->stok < $item->jumlah) {
                return back()->with('error', 'Insufficient stock for product: ' . $item->nama_produk);
            }
        }

        // Reduce stock
        foreach ($pesanan->items as $item) {
            $produk = $item->produk;
            $produk->stok -= $item->jumlah;
            $produk->save();
        }

        // Update status
        $pesanan->status = 'Dikemas';
        $pesanan->save();

        return back()->with('success', 'Order has been confirmed and stock reduced.');
    }

    public function kirim($id)
    {
        Pesanan::where('id_pesanan', $id)->update(['status' => 'Dikirim']);
        return back()->with('success', 'Order has been marked as shipped.');
    }

    public function terkirim(Request $request, $id)
    {
        $request->validate(['nomor_resi' => 'required|string|max:255']);

        Pengiriman::create([
            'id_pesanan' => $id,
            'nomor_resi' => $request->nomor_resi,
            'tanggal_kirim' => now(),
        ]);

        Pesanan::where('id_pesanan', $id)->update(['status' => 'Terkirim']);

        return back()->with('success', 'Tracking number has been saved.');
    }

    public function selesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status = 'Selesai';
        $pesanan->waktu_selesai = now();
        $pesanan->save();

        return back()->with('success', 'Order has been completed.');
    }
}
