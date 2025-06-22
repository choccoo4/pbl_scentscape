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
        // Ambil data pesanan
        $pesanan = Pesanan::with(['pengguna', 'items', 'pembayaran'])->findOrFail($id);

        return view('sellers.detail_pesanan', compact('pesanan'));
    }

    public function tolak($id)
    {
        $pesanan = Pesanan::with('items.produk')->findOrFail($id);

        if (!in_array($pesanan->status, ['Menunggu Verifikasi', 'Menunggu Pembayaran'])) {
            return back()->with('error', 'Pesanan tidak bisa ditolak di status ini.');
        }

        // Kembalikan stok
        foreach ($pesanan->items as $item) {
            $produk = $item->produk;
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->save();
            }
        }

        // Update status pesanan
        $pesanan->status = 'Ditolak';
        $pesanan->save();

        return back()->with('success', 'Pesanan ditolak & stok dikembalikan.');
    }


    public function konfirmasi($id)
    {
        $pesanan = Pesanan::with('items.produk')->findOrFail($id);

        if ($pesanan->status !== 'Menunggu Verifikasi') {
            return back()->with('error', 'Pesanan tidak dalam status verifikasi.');
        }

        // Cek stok cukup dulu
        foreach ($pesanan->items as $item) {
            $produk = $item->produk;
            if (!$produk || $produk->stok < $item->jumlah) {
                return back()->with('error', 'Stok tidak cukup untuk produk: ' . $item->nama_produk);
            }
        }

        // Kurangi stok
        foreach ($pesanan->items as $item) {
            $produk = $item->produk;
            $produk->stok -= $item->jumlah;
            $produk->save();
        }

        // Update status
        $pesanan->status = 'Dikemas';
        $pesanan->save();

        return back()->with('success', 'Pesanan telah dikonfirmasi & stok dikurangi.');
    }

    public function kirim($id)
    {
        Pesanan::where('id_pesanan', $id)->update(['status' => 'Dikirim']);
        return back()->with('success', 'Pesanan sudah dikirim.');
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

        return back()->with('success', 'Nomor resi berhasil disimpan.');
    }

    public function selesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status = 'Selesai';
        $pesanan->waktu_selesai = now();
        $pesanan->save();

        return back()->with('success', 'Pesanan telah diselesaikan.');
    }
}
