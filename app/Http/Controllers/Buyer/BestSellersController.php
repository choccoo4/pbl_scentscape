<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BestSellersController extends Controller
{
    public function bestSellers()
    {
        $products = [
            [
                'name' => 'Floraison',
                'price' => 'Rp 401.000',
                'img' => 'image.png',
                'gender' => 'For Her',
                'volume' => '50ml',
                'type' => 'EDP',
                'aromas' => [
                    ['icon' => 'flower', 'label' => 'Floral'],
                    ['icon' => 'drop', 'label' => 'Watery'],
                ],
                'slug' => 'floraison',
            ],
            [
                'name' => 'Ethereal',
                'price' => 'Rp 401.000',
                'img' => 'image2.png',
                'gender' => 'Unisex',
                'volume' => '30ml',
                'type' => 'EDT',
                'aromas' => [
                    ['icon' => 'leaf', 'label' => 'Green'],
                    ['icon' => 'sparkle', 'label' => 'Fresh'],
                ],
                'slug' => 'floraison',
            ],
            [
                'name' => 'Beige 96',
                'price' => 'Rp 401.000',
                'img' => 'image3.png',
                'gender' => 'For Him',
                'volume' => '75ml',
                'type' => 'Parfum',
                'aromas' => [
                    ['icon' => 'fire', 'label' => 'Spicy'],
                    ['icon' => 'drop', 'label' => 'Aquatic'],
                    ['icon' => 'smiley', 'label' => 'Playful'],
                ],
                'slug' => 'floraison',
            ],
            [
                'name' => 'Almalika',
                'price' => 'Rp 401.000',
                'img' => 'image4.png',
                'gender' => 'Unisex',
                'volume' => '50ml',
                'type' => 'EDP',
                'aromas' => [
                    ['icon' => 'crown', 'label' => 'Royal Oud'],
                    ['icon' => 'flower', 'label' => 'Rose'],
                ],
                'slug' => 'floraison',
            ],
        ];
        return view('buyer.best-sellers', compact('products'));
    }
}
