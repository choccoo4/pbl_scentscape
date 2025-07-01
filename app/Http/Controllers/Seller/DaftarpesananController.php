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
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'dikemas'              => 'Dikemas',
            'dikirim'              => 'Dikirim',
            'terkirim'             => 'Terkirim',
            'selesai'              => 'Selesai',
            'dibatalkan'           => 'Dibatalkan',
        ];

        // Query utama untuk pagination
        $query = Pesanan::query();

        // Query kedua khusus untuk menghitung jumlah semua status (tidak dipengaruhi filter & pagination)
        $countQuery = Pesanan::query();

        // Filter berdasarkan status (jika ada)
        if ($statusFilter && strtolower($statusFilter) !== 'semua') {
            if (strtolower($statusFilter) === 'dikirim') {
                $query->whereIn('status', ['Dikirim', 'Terkirim']);
            } elseif (isset($statusMap[strtolower($statusFilter)])) {
                $query->where('status', $statusMap[strtolower($statusFilter)]);
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
            'Menunggu Pembayaran'  => $countQuery->clone()->where('status', 'Menunggu Pembayaran')->count(),
            'Menunggu Verifikasi'  => $countQuery->clone()->where('status', 'Menunggu Verifikasi')->count(),
            'Dikemas'              => $countQuery->clone()->where('status', 'Dikemas')->count(),
            'Dikirim'              => $countQuery->clone()->whereIn('status', ['Dikirim', 'Terkirim'])->count(),
            'Selesai'              => $countQuery->clone()->where('status', 'Selesai')->count(),
            'Dibatalkan'           => $countQuery->clone()->where('status', 'Dibatalkan')->count(),
        ];

        return view('sellers.daftar_pesanan', compact('pesanan', 'statusCounts'));
    }
}
