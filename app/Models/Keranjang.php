<?php
// Model Keranjang
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'waktu_ditambahkan',
    ];

    protected $casts = [
        'waktu_ditambahkan' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(KeranjangItem::class, 'id_keranjang', 'id_keranjang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    // Method untuk menghitung total keranjang
    public function getTotalAmount()
    {
        return $this->items->sum(function ($item) {
            return $item->jumlah_produk * $item->produk->harga;
        });
    }

    // Method untuk menghitung total item
    public function getTotalItems()
    {
        return $this->items->sum('jumlah_produk');
    }
}