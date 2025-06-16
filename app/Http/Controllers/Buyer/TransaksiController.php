<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class TransaksiController extends Controller
{
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $idPesanan = session('pesanan_id');
        if (!$idPesanan) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        $pesanan = Pesanan::findOrFail($idPesanan);

        if (now()->greaterThan($pesanan->batas_waktu_pembayaran)) {
            $pesanan->status = 'Dibatalkan';
            $pesanan->save();
            return redirect()->route('transaksi.show', $pesanan->id)
                ->with('error', 'Waktu pembayaran telah habis. Transaksi dibatalkan.');
        }

        // Rename nama file
        $nomorPesanan = $pesanan->nomor_pesanan;
        $ext = $request->file('bukti')->getClientOriginalExtension();
        $filename = $nomorPesanan . '.' . $ext;

        // Simpan ke storage/public/bukti_pembayaran/
        $path = $request->file('bukti')->storeAs('bukti_pembayaran', $filename, 'public');

        // Simpan atau update pembayaran
        $pembayaran = Pembayaran::firstOrNew(['id_pesanan' => $idPesanan]);
        $pembayaran->path_bukti = $path;
        $pembayaran->save();

        // Ubah status pesanan ke "Menunggu Verifikasi"
        $pesanan->status = 'Menunggu Verifikasi';
        $pesanan->save();

        return redirect()->route('order.history')->with('success', 'Bukti pembayaran berhasil diupload dan menunggu verifikasi.');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('pengguna', 'items', 'pembayaran')->find($id);

        if (!$pesanan || $pesanan->id_pengguna !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Kamu tidak punya akses ke transaksi ini.');
        }

        // Otomatis batalkan kalau udah lewat waktu pembayaran
        if ($pesanan->status === 'Menunggu Pembayaran' && now()->greaterThan($pesanan->batas_waktu_pembayaran)) {
            $pesanan->status = 'Dibatalkan';
            $pesanan->save();
        }

        return view('buyer.transaksi', compact('pesanan'));
    }
}
