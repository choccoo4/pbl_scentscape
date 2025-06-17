<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Aroma;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'no_produk';
    public $timestamps = false;

    protected $fillable = [
        'nama_produk',
        'harga',
        'deskripsi',
        'stok',
        'gambar', // nanti bisa simpan array JSON path 4 gambar
        'volume',
        'label_kategori',
        'tipe_parfum',
        'waktu_dibuat',
        'waktu_diperbarui',
    ];

    protected $casts = [
        'gambar' => 'array', // jika gambar disimpan sebagai JSON array
    ];

    // Jika ingin relasi dengan aroma (banyak ke banyak)
    public function aroma()
    {
        return $this->belongsToMany(
            Aroma::class,
            'produk_aroma',
            'no_produk',
            'id_kategori'
        );
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->nama_produk);
    }

    public function pesananItems()
    {
        return $this->hasMany(\App\Models\PesananItem::class, 'id_produk', 'no_produk');
    }

    public function totalPenjualan()
    {
        return DB::table('pesanan_item')
            ->join('pesanan', 'pesanan_item.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('pesanan_item.no_produk', $this->no_produk)
            ->where('pesanan.status', 'Selesai')
            ->sum('pesanan_item.jumlah');
    }
}
