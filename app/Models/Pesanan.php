<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $primaryKey = 'id_pesanan';

    public $timestamps = false;

    protected $casts = [
        'waktu_pemesanan' => 'datetime',
        'batas_waktu_pembayaran' => 'datetime',
    ];

    protected $fillable = [
        'id_pengguna',
        'nomor_pesanan',
        'total',
        'ongkir',
        'status',
        'waktu_pemesanan',
        'batas_waktu_pembayaran',
    ];

    // Relasi ke pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    // Relasi ke item pesanan
    public function items()
    {
        return $this->hasMany(PesananItem::class, 'id_pesanan');
    }

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan');
    }

    // Relasi ke invoice
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id_pesanan');
    }

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pengguna');
    }
}
