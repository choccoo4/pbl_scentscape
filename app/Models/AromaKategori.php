<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AromaKategori extends Model
{
    protected $table = 'aroma_kategori';

    protected $fillable = ['nama', 'icon', 'gambar'];

    // Optional: kalau mau bikin relasi ke aroma
    public function aroma()
    {
        return $this->hasMany(Aroma::class, 'aroma_kategori_id');
    }
}
