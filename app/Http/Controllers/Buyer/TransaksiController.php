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
    public function show($id)
    {
        $pesanan = Pesanan::with('pengguna', 'items', 'pembayaran')->find($id);

        if (!$pesanan || $pesanan->id_pengguna !== Auth::id()) {
            return redirect()->route('home')->with('error', 'You do not have access to this transaction.');
        }

        // Automatically cancel if past the payment deadline
        if ($pesanan->status === 'Menunggu Pembayaran' && now()->greaterThan($pesanan->batas_waktu_pembayaran)) {
            $pesanan->status = 'Dibatalkan';
            $pesanan->save();
        }

        return view('buyer.transaksi', compact('pesanan'));
    }

    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $idPesanan = session('pesanan_id');
        if (!$idPesanan) {
            return redirect()->route('home')->with('error', 'Transaction not found.');
        }

        $pesanan = Pesanan::findOrFail($idPesanan);

        if (now()->greaterThan($pesanan->batas_waktu_pembayaran)) {
            $pesanan->status = 'Dibatalkan';
            $pesanan->save();
            return redirect()->route('transaksi.show', $pesanan->id)
                ->with('error', 'Payment time has expired. Transaction was automatically cancelled.');
        }

        // Rename the uploaded file
        $nomorPesanan = $pesanan->nomor_pesanan;
        $ext = $request->file('bukti')->getClientOriginalExtension();
        $filename = $nomorPesanan . '.' . $ext;

        // Store to storage/public/bukti_pembayaran/
        $path = $request->file('bukti')->storeAs('bukti_pembayaran', $filename, 'public');

        // Save or update payment
        $pembayaran = Pembayaran::firstOrNew(['id_pesanan' => $idPesanan]);
        $pembayaran->path_bukti = $path;
        $pembayaran->save();

        // Update status to "Waiting for Verification"
        $pesanan->status = 'Menunggu Verifikasi';
        $pesanan->save();

        return redirect()->route('order.history')->with('success', 'Payment proof uploaded successfully. Waiting for verification.');
    }
}
