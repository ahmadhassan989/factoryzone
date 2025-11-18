<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BuyerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $buyer = $request->user();

        $orders = Order::with('factory')
            ->where('buyer_id', $buyer->id)
            ->latest()
            ->take(10)
            ->get();

        return view('buyer.dashboard', [
            'buyer' => $buyer,
            'orders' => $orders,
        ]);
    }
}

