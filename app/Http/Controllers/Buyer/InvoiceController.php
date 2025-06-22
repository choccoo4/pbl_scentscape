<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function generate($id)
    {
        $pesanan = Pesanan::with(['items', 'pembeli.pengguna'])->find($id);

        if (
            !$pesanan ||
            $pesanan->id_pengguna !== Auth::id() ||
            !in_array($pesanan->status, ['Menunggu Verifikasi', 'Dibatalkan', 'Selesai', 'Dikirim', 'Dikemas'])
        ) {
            return redirect()->route('transaksi.detail', ['id' => $id])
                ->with('error', 'Invoice belum tersedia atau kamu tidak memiliki akses.');
        }

        $filename = 'invoice-' . $pesanan->nomor_pesanan . '.pdf';
        $path = 'invoice/' . $filename;

        // Generate PDF
        $pdf = Pdf::loadView('buyer.pdf', compact('pesanan'));
        Storage::disk('public')->put($path, $pdf->output());

        // Simpan ke tabel invoice (cek kalau belum ada)
        Invoice::firstOrCreate(
            ['id_pesanan' => $pesanan->id_pesanan],
            ['path_invoice' => $path]
        );

        // Tampilkan langsung ke user
        return $pdf->stream($filename);
    }
}
