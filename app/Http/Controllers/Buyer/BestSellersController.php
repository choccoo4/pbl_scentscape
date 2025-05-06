<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BestSellersController extends Controller
{
    public function bestSellers()
    {
        return view('buyer.best-sellers');
    }
}
