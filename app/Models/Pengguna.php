<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Penjual;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'foto_profil',
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

    protected $casts = [
        'waktu_perubahan' => 'datetime',
    ];

    public function penjual()
    {
        return $this->hasOne(Penjual::class, 'id_pengguna', 'id_pengguna');
    }

    public function pembeli()
    {
        return $this->hasOne(Pembeli::class, 'id_pengguna', 'id_pengguna');
    }
}
