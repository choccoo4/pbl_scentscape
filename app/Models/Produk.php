<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'no_produk';
    public $timestamps = false;

    protected $fillable = [
        'nama_produk',
        'tipe_parfum',
        'label_kategori',
        'deskripsi',
        'gambar',
        'stok',
        'harga',
        'volume',
        'id_kategori',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}


