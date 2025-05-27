<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pembeli;
use App\Models\Penjual;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';  // tambah ini
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'role',
        'waktu_pembuatan',
        'waktu_perubahan',
    ];

    protected $hidden = [
        'password',
    ];

    public function pembeli()
    {
        return $this->hasOne(Pembeli::class, 'id_pengguna');
    }

    public function penjual()
    {
        return $this->hasOne(Penjual::class, 'id_pengguna');
    }
}
