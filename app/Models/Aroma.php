<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aroma extends Model
{
    protected $table = 'aroma'; // nama tabel sesuai migration
    protected $primaryKey = 'id_kategori'; // primary key yang kamu pake

    public $timestamps = false; // karena migrasi kamu ga ada created_at/updated_at

    protected $fillable = ['nama'];

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'produk_aroma', 'aroma_id', 'produk_id');
    }
}
