<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengguna;

class Penjual extends Model
{
    use HasFactory;

    protected $table = 'penjual';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;

    protected $fillable = ['id_pengguna', 'deskripsi_toko'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
