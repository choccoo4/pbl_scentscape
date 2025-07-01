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
        $userId = Auth::id(); // ID penjual jika dibutuhkan

        $statusFilter = $request->query('status');
        $search = $request->query('search');

        // Mapping status dari query string ke format database
        $statusMap = [
            'menunggu_pembayaran' => ['Menunggu Pembayaran'],
            'menunggu_verifikasi' => ['Menunggu Verifikasi'],
            'dikemas'              => ['Dikemas'],
            'dikirim'              => ['Dikirim', 'Terkirim'],
            'dibatalkan'           => ['Dibatalkan', 'Ditolak'],
            'selesai'              => ['Selesai'],
        ];

        // Query utama untuk pagination
        $query = Pesanan::query();

        // Query kedua khusus untuk menghitung jumlah semua status (tidak dipengaruhi filter & pagination)
        $countQuery = Pesanan::query();

        // Filter berdasarkan status (jika ada)
        if ($statusFilter && strtolower($statusFilter) !== 'semua') {
            $key = strtolower($statusFilter);
            if (isset($statusMap[$key])) {
                $query->whereIn('status', $statusMap[$key]);
            }
        }

        // Filter berdasarkan pencarian nomor pesanan
        if ($search) {
            $query->where('nomor_pesanan', 'like', "%{$search}%");
        }

        // Urutkan berdasarkan waktu pemesanan terbaru
        $query->orderBy('waktu_pemesanan', 'desc');

        // Ambil data dengan pagination dan tetap mempertahankan query string
        $pesanan = $query->paginate(10)->withQueryString();

        // Hitung jumlah semua pesanan berdasarkan status (tidak terkena filter/pagination)
        $statusCounts = [
            'Menunggu Pembayaran' => $countQuery->clone()->where('status', 'Menunggu Pembayaran')->count(),
            'Menunggu Verifikasi' => $countQuery->clone()->where('status', 'Menunggu Verifikasi')->count(),
            'Dikemas'             => $countQuery->clone()->where('status', 'Dikemas')->count(),
            'Dikirim'             => $countQuery->clone()->whereIn('status', ['Dikirim', 'Terkirim'])->count(),
            'Selesai'             => $countQuery->clone()->where('status', 'Selesai')->count(),
            'Dibatalkan'          => $countQuery->clone()->whereIn('status', ['Dibatalkan', 'Ditolak'])->count(),
        ];

        return view('sellers.daftar_pesanan', compact('pesanan', 'statusCounts'));
    }
}
