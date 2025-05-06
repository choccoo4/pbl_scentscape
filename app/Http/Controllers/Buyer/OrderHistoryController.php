<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function orderHistory()
    {
        return view('buyer.order-history');
    }
}
