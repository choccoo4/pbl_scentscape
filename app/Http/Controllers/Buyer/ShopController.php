<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Aroma;
use App\Helpers\ProductCardFormatter;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $query       = $request->input('q');
        $sort        = $request->input('sort');
        $aromaFilter = $request->input('aroma');
        $gender      = $request->input('gender');
        $type        = $request->input('type');
        $volume      = $request->input('volume');
        $harga       = $request->input('harga');
        $multiAroma  = $request->input('categories', []);

        // Mapping tipe parfum untuk pencocokan label di database
        $typeMap = [
            'EDP'        => 'Eau De Parfum (EDP)',
            'EDT'        => 'Eau De Toilette (EDT)',
            'BodyMist'   => 'Body Mist',
            'Cologne'    => 'Cologne',
            'ParfumOil'  => 'Parfum Oil',
            'SolidParfum'=> 'Solid Perfume',
        ];

        $products = Produk::with('aroma.aromaKategori')
            ->when($query, fn($q) =>
                $q->where('nama_produk', 'like', "%$query%")
                  ->orWhere('deskripsi', 'like', "%$query%"))

            ->when($gender, fn($q) => $q->where('label_kategori', $gender))

            ->when($type, function ($q) use ($type, $typeMap) {
                return isset($typeMap[$type])
                    ? $q->where('tipe_parfum', $typeMap[$type])
                    : $q;
            })

            ->when($volume, function ($q) use ($volume) {
                if ($volume === 'small')  return $q->where('volume', '<', 30);
                if ($volume === 'medium') return $q->whereBetween('volume', [30, 60]);
                if ($volume === 'large')  return $q->where('volume', '>', 60);
            })

            ->when($harga, function ($q) use ($harga) {
                if ($harga === 'low')  return $q->where('harga', '<', 100000);
                if ($harga === 'mid')  return $q->whereBetween('harga', [100000, 300000]);
                if ($harga === 'high') return $q->where('harga', '>', 300000);
            })

            ->when(!empty($multiAroma), fn($q) =>
                $q->whereHas('aroma', fn($aq) => $aq->whereIn('nama', $multiAroma)))

            ->when($aromaFilter, fn($q) =>
                $q->whereHas('aroma', fn($aq) => $aq->where('nama', $aromaFilter)))

            ->when($sort === 'price_asc', fn($q) => $q->orderBy('harga', 'asc'))
            ->when($sort === 'price_desc', fn($q) => $q->orderBy('harga', 'desc'))
            ->when($sort === 'name_asc', fn($q) => $q->orderBy('nama_produk', 'asc'))
            ->when(!$sort || $sort === 'newest', fn($q) => $q->orderBy('waktu_dibuat', 'desc'))

            // PAKAI PAGINATION
            ->paginate(10)
            ->withQueryString()
            ->through(fn($product) => ProductCardFormatter::from($product)); // tetap bisa mapping

        $aromas = Aroma::orderBy('nama')->get();

        return view('buyer.shop', compact('products', 'aromas'));
    }
}
