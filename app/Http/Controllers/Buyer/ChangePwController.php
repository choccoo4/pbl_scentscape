<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePwController extends Controller
{
    public function changePw()
    {
        return view('buyer.change-pw');
    }
}
