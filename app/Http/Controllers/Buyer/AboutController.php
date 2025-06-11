<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjual;

class AboutController extends Controller
{
    public function about()
    {
        // Ambil penjual pertama beserta relasi pengguna (misalnya untuk info toko)
        $penjual = Penjual::with('pengguna')->first();

        return view('buyer.about', compact('penjual'));
    }
}
