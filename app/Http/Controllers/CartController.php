<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Dummy data untuk cartItems
        $cartItems = [
            [
                'name' => 'Almalika',
                'price' => 401000,
                'img' => 'image6-1.png',
                'quantity' => 1,
            ],
            [
                'name' => 'Scent Designer Kit',
                'price' => 341000,
                'img' => 'image7-1.png',
                'quantity' => 1,
            ]
        ];

        return view('buyer.cart', compact('cartItems'));
    }
}
