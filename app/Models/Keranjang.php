<?php
// Model Keranjang
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;

    protected $fillable = ['id_pengguna'];

    public function items(): HasMany
    {
        return $this->hasMany(KeranjangItem::class, 'id_keranjang');
    }
}