<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop()
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
            [
                'name' => 'La Bohème',
                'price' => 'Rp 401.000',
                'img' => 'image5.png',
                'gender' => 'For Her',
                'volume' => '40ml',
                'type' => 'EDT',
                'aromas' => [
                    ['icon' => 'sparkle', 'label' => 'Bright'],
                    ['icon' => 'star', 'label' => 'Powdery'],
                ],
                'slug' => 'floraison',
            ],
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
        return view('buyer.shop', compact ('products'));
    }
}
