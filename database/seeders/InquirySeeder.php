<?php

namespace Database\Seeders;

use App\Models\Factory;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $tomatoes = Product::where('slug', 'premium-jordanian-tomatoes')->first();
        $bottles = Product::where('slug', 'pet-bottles-1l')->first();
        $cotton = Product::where('slug', 'cotton-fabric-roll-100m')->first();

        $inquiries = [
            [
                'product' => $tomatoes,
                'buyer_name' => 'Mohammad Saleh',
                'buyer_email' => 'm.saleh@example.com',
                'quantity' => 500,
                'message' => 'Looking for regular weekly shipments of 500 kg.',
                'source' => 'marketplace',
                'status' => 'new',
            ],
            [
                'product' => $bottles,
                'buyer_name' => 'Green Juice Co.',
                'buyer_email' => 'purchasing@greenjuice.example.com',
                'quantity' => 10000,
                'message' => 'Please send price list for 10k and 50k PET bottles.',
                'source' => 'marketplace',
                'status' => 'in_review',
            ],
            [
                'product' => $cotton,
                'buyer_name' => 'Al-Sharq Garments',
                'buyer_email' => 'sourcing@alsharqgarments.example.com',
                'quantity' => 20,
                'message' => 'Need 20 rolls of 100% cotton fabric. Share specs and lead time.',
                'source' => 'storefront',
                'status' => 'new',
            ],
        ];

        foreach ($inquiries as $data) {
            if (! $data['product']) {
                continue;
            }

            Inquiry::create([
                'factory_id' => $data['product']->factory_id,
                'product_id' => $data['product']->id,
                'buyer_name' => $data['buyer_name'],
                'buyer_email' => $data['buyer_email'],
                'buyer_phone' => null,
                'quantity' => $data['quantity'],
                'message' => $data['message'],
                'source' => $data['source'],
                'status' => $data['status'],
            ]);
        }
    }
}

