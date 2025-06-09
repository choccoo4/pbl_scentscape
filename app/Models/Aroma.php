<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AromaKategori;

class Aroma extends Model
{
    protected $table = 'aroma'; // nama tabel sesuai migration
    protected $primaryKey = 'id_kategori'; // primary key yang kamu pake

    public $timestamps = false; // karena migrasi kamu ga ada created_at/updated_at

    protected $fillable = ['nama', 'aroma_kategori_id'];

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'produk_aroma', 'id_kategori', 'no_produk');
    }

    public function aromaKategori()
    {
        return $this->belongsTo(AromaKategori::class, 'aroma_kategori_id');
    }
}
