<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $food = Industry::where('code', 'FOOD')->first();
        $plastics = Industry::where('code', 'PLASTICS')->first();
        $textiles = Industry::where('code', 'TEXTILES')->first();

        $categories = [
            [
                'name' => 'Fresh Produce',
                'slug' => 'fresh-produce',
                'industry_id' => $food?->id,
                'sort_order' => 10,
            ],
            [
                'name' => 'Dairy Products',
                'slug' => 'dairy-products',
                'industry_id' => $food?->id,
                'sort_order' => 20,
            ],
            [
                'name' => 'Plastic Packaging',
                'slug' => 'plastic-packaging',
                'industry_id' => $plastics?->id,
                'sort_order' => 10,
            ],
            [
                'name' => 'Textile Fabrics',
                'slug' => 'textile-fabrics',
                'industry_id' => $textiles?->id,
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $data) {
            ProductCategory::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'description' => null,
                    'parent_id' => null,
                    'industry_id' => $data['industry_id'],
                    'sort_order' => $data['sort_order'],
                ],
            );
        }
    }
}

