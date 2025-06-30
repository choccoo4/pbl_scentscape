<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aroma;

class AromaKategoriController extends Controller
{
    public function getChildren($id)
    {
        $children = Aroma::where('aroma_kategori_id', $id)
            ->join('aroma_kategori', 'aroma.aroma_kategori_id', '=', 'aroma_kategori.id')
            ->select('aroma.id_kategori', 'aroma.nama', 'aroma_kategori.icon')
            ->get();

        return response()->json($children);
    }
}
