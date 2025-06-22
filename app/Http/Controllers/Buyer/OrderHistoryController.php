<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function orderHistory()
    {
        $userId = Auth::id();

        $pesanan = Pesanan::where('id_pengguna', $userId)
            ->orderBy('waktu_pemesanan', 'desc')
            ->get();

        return view('buyer.order_history', compact('pesanan'));
    }
}
