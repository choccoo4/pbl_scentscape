<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aroma;


class AromaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:aroma,nama|max:255',
            'kategori_id' => 'required|exists:aroma_kategori,id'
        ]);

        $aroma = Aroma::create([
            'nama' => $request->nama,
            'aroma_kategori_id' => $request->kategori_id
        ]);

        return response()->json([
            'success' => true,
            'aroma' => $aroma->nama
        ]);
    }
}
