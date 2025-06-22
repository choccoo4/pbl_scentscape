<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RekapPenjualan extends Model
{
    use HasFactory;

    protected $table = 'rekap_penjualan';
    protected $primaryKey = 'id_rekapitulasi';
    public $timestamps = false;
    
    protected $fillable = [
        'id_pesanan',
        'rentang_tanggal_awal',
        'rentang_tanggal_akhir',
    ];

    protected $casts = [
        'rentang_tanggal_awal' => 'date',
        'rentang_tanggal_akhir' => 'date',
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_penjualan', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ]);
    }

    // Scope untuk filter berdasarkan rentang tanggal rekap
    public function scopeByRekapRange($query, $startDate, $endDate)
    {
        return $query->where('rentang_tanggal_awal', $startDate)
                    ->where('rentang_tanggal_akhir', $endDate);
    }

    // Method untuk generate rekap otomatis
    public static function generateRekap($tanggalAwal, $tanggalAkhir)
    {
        // Hapus rekap yang sudah ada untuk rentang tanggal ini (jika ada)
        self::where('rentang_tanggal_awal', $tanggalAwal)
            ->where('rentang_tanggal_akhir', $tanggalAkhir)
            ->delete();

        // Ambil data penjualan dari PesananItem
        $penjualanItems = PesananItem::with(['produk', 'pesanan'])
            ->whereHas('pesanan', function ($q) use ($tanggalAwal, $tanggalAkhir) {
                $q->whereBetween('waktu_pemesanan', [
                    Carbon::parse($tanggalAwal)->startOfDay(),
                    Carbon::parse($tanggalAkhir)->endOfDay()
                ])
                ->where('status', 'Selesai');
            })
            ->get();

        // Hitung grand total
        $grandTotal = $penjualanItems->sum(function ($item) {
            return $item->harga_satuan * $item->jumlah;
        });

        // Simpan hanya satu record rekap dengan rentang tanggal
        if ($penjualanItems->count() > 0) {
            $rekapItem = self::create([
                'id_pesanan' => $penjualanItems->first()->id_pesanan, // Ambil pesanan pertama sebagai referensi
                'rentang_tanggal_awal' => $tanggalAwal,
                'rentang_tanggal_akhir' => $tanggalAkhir,
            ]);
        }

        return [
            'data' => $penjualanItems,
            'grand_total' => $grandTotal,
            'total_transaksi' => $penjualanItems->count(),
            'total_quantity' => $penjualanItems->sum('jumlah')
        ];
    }
}