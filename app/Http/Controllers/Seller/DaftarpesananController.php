<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DaftarpesananController extends Controller
{
    public function daftarpesanan(Request $request)
    {
        $userId = Auth::id();

        // Ambil filter status dari query params, default null (semua)
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $statusMap = [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'ditolak' => 'Ditolak',
            'dikemas' => 'Dikemas',
            'dikirim' => 'Dikirim',
            'terkirim' => 'Terkirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        $query = Pesanan::query();

        // Filter status kalau ada dan bukan semua
        if ($statusFilter && strtolower($statusFilter) !== 'semua') {
            if (isset($statusMap[strtolower($statusFilter)])) {
                $query->where('status', $statusMap[strtolower($statusFilter)]);
            }
        }

        // Filter pencarian
        if ($search) {
            $query->where('nomor_pesanan', 'like', "%{$search}%");
            // Bisa ditambah filter lain misal nama pembeli, dll
        }

        $query->orderBy('waktu_pemesanan', 'desc');

        $pesanan = $query->paginate(10)->withQueryString();

        return view('sellers.daftarpesanan', compact('pesanan'));
    }
}
