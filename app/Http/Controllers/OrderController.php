<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_type' => ['required', 'in:piece,pack'],
            'buyer_name' => ['nullable', 'string', 'max:255'],
            'buyer_email' => ['nullable', 'email', 'max:255'],
            'buyer_phone' => ['nullable', 'string', 'max:255'],
        ]);

        $product = Product::with('factory')->findOrFail($data['product_id']);
        $buyer = $request->user();

        // Determine unit price based on unit type
        if ($data['unit_type'] === 'pack' && $product->pack_price !== null) {
            $unitPrice = $product->pack_price;
        } else {
            $unitPrice = $product->price ?? 0;
        }
        $totalPrice = $unitPrice * $data['quantity'];

        $order = Order::create([
            'buyer_id' => $buyer && $buyer->isBuyer() ? $buyer->id : null,
            'factory_id' => $product->factory_id,
            'status' => 'pending',
            'currency' => 'JOD',
            'subtotal' => $totalPrice,
            'total' => $totalPrice,
            'source' => $request->getHost() === config('app.url') ? 'marketplace' : 'storefront',
            'buyer_name' => $buyer?->name ?? $data['buyer_name'] ?? null,
            'buyer_email' => $buyer?->email ?? $data['buyer_email'] ?? null,
            'buyer_phone' => $data['buyer_phone'] ?? null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'unit_type' => $data['unit_type'],
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
        ]);

        return back()->with('status', 'order_created');
    }
}
