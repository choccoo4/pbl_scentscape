<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiftsController extends Controller
{
    public function gifts()
    {
        $products = [
            [
                'name' => 'Scent Designer Kit',
                'price' => 'Rp 180.000',
                'img' => 'image6.jpg',
                'gender' => 'Unisex',
                'volume' => '50ml',
                'type' => 'EDP',
                'aromas' => [
                    ['icon' => 'palette', 'label' => 'Creative'],
                    ['icon' => 'drop', 'label' => 'Fresh'],
                ],
                'slug' => 'scent-designer-kit',
            ],
            [
                'name' => 'Make it Gift',
                'price' => 'Rp 90.000',
                'img' => 'image7.jpg',
                'gender' => 'Gift Set',
                'volume' => '–',
                'type' => 'Bundle',
                'aromas' => [
                    ['icon' => 'gift', 'label' => 'Special'],
                    ['icon' => 'heart', 'label' => 'Romantic'],
                ],
                'slug' => 'make-it-gift',
            ],
        ];
        return view('buyer.gifts', compact('products'));
    }
}
