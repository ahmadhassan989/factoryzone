<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class FactoryOrderController extends Controller
{
    public function index(Request $request)
    {
        $factory = $request->user()->factory;

        $orders = Order::with(['items.product', 'buyer'])
            ->where('factory_id', $factory->id)
            ->latest()
            ->paginate(20);

        return view('factory.orders.index', [
            'factory' => $factory,
            'orders' => $orders,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $factory = $request->user()->factory;

        abort_unless($order->factory_id === $factory?->id, 403);

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);

        return redirect()
            ->route('factory.orders.index')
            ->with('status', 'order_status_updated');
    }
}
