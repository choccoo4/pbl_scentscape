<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Aroma;


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
}