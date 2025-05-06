<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Menambahkan kolom yang boleh diisi secara massal
    protected $fillable = ['name', 'category', 'price'];
}
