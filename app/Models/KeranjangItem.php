<?php
// Model KeranjangItem
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    protected $table = 'keranjang_item';
    public $timestamps = false;
    public $incrementing = false;
    
    // Jika menggunakan composite key, definisikan primary key
    protected $primaryKey = ['id_keranjang', 'no_produk'];

    protected $fillable = [
        'id_keranjang',
        'no_produk',
        'jumlah_produk',
    ];

    protected $casts = [
        'jumlah_produk' => 'integer',
    ];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'no_produk', 'no_produk');
    }

    // Method untuk menghitung subtotal item
    public function getSubtotal()
    {
        return $this->jumlah_produk * $this->produk->harga;
    }

    // Accessor untuk subtotal
    public function getSubtotalAttribute()
    {
        return $this->getSubtotal();
    }

    // Override untuk composite key
    protected function setKeysForSaveQuery($query)
    {
        $query->where('id_keranjang', $this->getAttribute('id_keranjang'))
              ->where('no_produk', $this->getAttribute('no_produk'));
        
        return $query;
    }
}