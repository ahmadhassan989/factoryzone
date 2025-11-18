<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $buyer = User::where('email', 'buyer@factoryzone.test')->first();

        $tomatoes = Product::where('slug', 'premium-jordanian-tomatoes')->first();
        $bottles = Product::where('slug', 'pet-bottles-1l')->first();

        if ($buyer && $tomatoes) {
            $this->createOrder($buyer, $tomatoes, [
                'quantity' => 300,
                'unit_type' => 'kg',
                'status' => 'confirmed',
            ]);
        }

        if ($buyer && $bottles) {
            $this->createOrder($buyer, $bottles, [
                'quantity' => 5000,
                'unit_type' => 'pack',
                'status' => 'pending',
            ]);
        }
    }

    private function createOrder(User $buyer, Product $product, array $data): void
    {
        $unitPrice = $product->base_price ?? 0;
        $total = $unitPrice * $data['quantity'];

        $order = Order::create([
            'buyer_id' => $buyer->id,
            'factory_id' => $product->factory_id,
            'status' => $data['status'],
            'currency' => $product->currency ?? 'JOD',
            'subtotal' => $total,
            'total' => $total,
            'source' => 'marketplace',
            'buyer_name' => $buyer->name,
            'buyer_email' => $buyer->email,
            'buyer_phone' => null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'unit_type' => $data['unit_type'],
            'unit_price' => $unitPrice,
            'total_price' => $total,
        ]);
    }
}

