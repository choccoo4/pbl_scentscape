<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
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
        ];

        $ingredients = [
            ['name' => 'Musk', 'img' => 'musk.jpg'],
            ['name' => 'Bergamot', 'img' => 'bergamot.jpeg'],
            ['name' => 'Amber', 'img' => 'amber.jpeg'],
            ['name' => 'Patchouli', 'img' => 'patchouli.jpg'],
            ['name' => 'Sandalwood', 'img' => 'sandalwood.jpeg'],
            ['name' => 'Vanilla', 'img' => 'vanilla.jpg'],
            ['name' => 'Jasmine', 'img' => 'jasmine.jpeg'],
            ['name' => 'Cedarwood', 'img' => 'cedarwood.jpg'],
        ];
        return view('buyer.home', compact('products', 'ingredients'));
    }
}
