<?php

namespace Database\Seeders;

use App\Models\Factory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $freshProduce = ProductCategory::where('slug', 'fresh-produce')->first();
        $dairy = ProductCategory::where('slug', 'dairy-products')->first();
        $packaging = ProductCategory::where('slug', 'plastic-packaging')->first();
        $fabrics = ProductCategory::where('slug', 'textile-fabrics')->first();

        $jordanFresh = Factory::where('slug', 'jordan-fresh-foods')->first();
        $ammanPlastics = Factory::where('slug', 'amman-plastics')->first();
        $desertTextiles = Factory::where('slug', 'desert-textiles')->first();

        $products = [
            [
                'factory' => $jordanFresh,
                'category' => $freshProduce,
                'name' => 'Premium Jordanian Tomatoes',
                'slug' => 'premium-jordanian-tomatoes',
                'sku' => 'FOOD-TOM-10KG',
                'unit' => 'kg',
                'base_price' => 1.80,
                'currency' => 'JOD',
                'status' => 1,
            ],
            [
                'factory' => $jordanFresh,
                'category' => $dairy,
                'name' => 'Fresh White Cheese 500g',
                'slug' => 'fresh-white-cheese-500g',
                'sku' => 'FOOD-CHS-500G',
                'unit' => 'piece',
                'base_price' => 2.50,
                'currency' => 'JOD',
                'status' => 1,
            ],
            [
                'factory' => $ammanPlastics,
                'category' => $packaging,
                'name' => 'PET Bottles 1L',
                'slug' => 'pet-bottles-1l',
                'sku' => 'PLS-PET-1L',
                'unit' => 'pack',
                'base_price' => 6.50,
                'currency' => 'JOD',
                'status' => 1,
            ],
            [
                'factory' => $desertTextiles,
                'category' => $fabrics,
                'name' => 'Cotton Fabric Roll 100m',
                'slug' => 'cotton-fabric-roll-100m',
                'sku' => 'TXT-COT-ROLL',
                'unit' => 'roll',
                'base_price' => 120,
                'currency' => 'JOD',
                'status' => 1,
            ],
        ];

        foreach ($products as $data) {
            if (! $data['factory']) {
                continue;
            }

            $product = Product::updateOrCreate(
                ['factory_id' => $data['factory']->id, 'slug' => $data['slug']],
                [
                    'product_category_id' => $data['category']?->id,
                    'name' => $data['name'],
                    'sku' => $data['sku'],
                    'description' => null,
                    'attributes' => [],
                    'status' => $data['status'],
                    'base_price' => $data['base_price'],
                    'currency' => $data['currency'],
                    'unit' => $data['unit'],
                    'price' => $data['base_price'],
                    'price_type' => 'fixed',
                    'pack_size' => null,
                    'pack_price' => null,
                    'is_published' => true,
                    'is_published_storefront' => true,
                    'is_published_marketplace' => true,
                ],
            );

            // Sample media (placeholder URLs)
            ProductMedia::updateOrCreate(
                ['product_id' => $product->id, 'position' => 0],
                [
                    'type' => 'image',
                    'url' => 'https://via.placeholder.com/600x400?text=' . urlencode($data['name']),
                ],
            );
        }
    }
}

