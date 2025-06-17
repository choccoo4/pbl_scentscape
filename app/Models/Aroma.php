<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AromaKategori;
use App\Models\Produk;

class Aroma extends Model
{
    protected $table = 'aroma'; // Nama tabel di database
    protected $primaryKey = 'id_kategori'; // Primary key tabel aroma

    public $timestamps = false; // Karena tidak menggunakan created_at & updated_at

    protected $fillable = ['nama', 'aroma_kategori_id'];

    // Relasi many-to-many ke produk
    public function produk()
    {
        return $this->belongsToMany(
            Produk::class,
            'produk_aroma',     // nama tabel pivot
            'id_kategori',      // foreign key di pivot ke Aroma
            'no_produk'         // foreign key di pivot ke Produk
        );
    }

    // Relasi ke aroma kategori
    public function aromaKategori()
    {
        return $this->belongsTo(AromaKategori::class, 'aroma_kategori_id');
    }
}
