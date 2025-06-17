<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ProductCardFormatter
{
    public static function from($product)
    {
        return [
            'id' => $product->no_produk,
            'name' => $product->nama_produk,
            'price' => 'Rp ' . number_format($product->harga, 0, ',', '.'),
            'img' => is_array($product->gambar) && count($product->gambar) > 0
                ? $product->gambar[0]
                : 'default.jpg',
            'gender' => $product->label_kategori,
            'volume' => $product->volume,
            'type' => self::shortType($product->tipe_parfum)['short'],
            'type_full' => self::shortType($product->tipe_parfum)['full'],
            'slug' => Str::slug($product->nama_produk),
            'deskripsi' => self::excerpt($product->deskripsi, 15),
            'aroma' => $product->aroma->map(function ($aroma) {
                return [
                    'icon' => $aroma->aromaKategori?->icon ?? 'flower',
                    'label' => $aroma->nama,
                ];
            }),
        ];
    }

    private static function excerpt($text, $wordLimit = 15)
    {
        $words = str_word_count(strip_tags($text), 1); // ambil kata aja
        $excerpt = implode(' ', array_slice($words, 0, $wordLimit));
        return count($words) > $wordLimit ? $excerpt . '...' : $excerpt;
    }

    private static function shortType($tipe)
    {
        return match ($tipe) {
            'Eau De Parfum (EDP)' => ['short' => 'EDP', 'full' => 'Eau De Parfum'],
            'Eau De Toilette (EDT)' => ['short' => 'EDT', 'full' => 'Eau De Toilette'],
            'Body Mist' => ['short' => 'Mist', 'full' => 'Body Mist'],
            'Cologne' => ['short' => 'Cologne', 'full' => 'Cologne'],
            'Perfume Oil' => ['short' => 'Oil', 'full' => 'Perfume Oil'],
            'Solid Perfume' => ['short' => 'Solid', 'full' => 'Solid Perfume'],
            default => ['short' => $tipe, 'full' => $tipe],
        };
    }
}
