<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    public function index(Request $request)
    {
        $buyer = $request->user();

        $orders = Order::with(['factory', 'items.product'])
            ->where('buyer_id', $buyer->id)
            ->latest()
            ->paginate(20);

        return view('buyer.orders.index', [
            'buyer' => $buyer,
            'orders' => $orders,
        ]);
    }
}

