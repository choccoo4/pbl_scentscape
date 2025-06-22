<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function generate($id)
    {
        // Include pengiriman relation untuk mendapatkan data resi dan waktu kirim
        $pesanan = Pesanan::with(['items', 'pembeli.pengguna', 'pengiriman'])->find($id);

        if (
            !$pesanan ||
            $pesanan->id_pengguna !== Auth::id() ||
            !in_array($pesanan->status, ['Menunggu Verifikasi', 'Dibatalkan', 'Selesai', 'Dikirim', 'Dikemas'])
        ) {
            return redirect()->route('transaksi.detail', ['id' => $id])
                ->with('error', 'Invoice belum tersedia atau kamu tidak memiliki akses.');
        }

        $pdf = Pdf::loadView('buyer.pdf', compact('pesanan'));
        return $pdf->stream('invoice-' . $pesanan->nomor_pesanan . '.pdf');
    }
}