<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiftsController extends Controller
{
    public function gifts()
    {
        return view('buyer.gifts');
    }
}
