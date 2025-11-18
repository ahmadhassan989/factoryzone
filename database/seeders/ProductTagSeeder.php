<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTagSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $tagsBySlug = Tag::whereIn('slug', ['export-ready', 'iso-certified', 'private-label'])
            ->get()
            ->keyBy('slug');

        $products = Product::all();

        foreach ($products as $product) {
            $attach = [];

            if ($product->factory?->slug === 'jordan-fresh-foods') {
                $attach = ['export-ready', 'iso-certified'];
            } elseif ($product->factory?->slug === 'amman-plastics') {
                $attach = ['export-ready', 'private-label'];
            } elseif ($product->factory?->slug === 'desert-textiles') {
                $attach = ['export-ready'];
            }

            $ids = collect($attach)
                ->map(fn (string $slug) => $tagsBySlug[$slug]->id ?? null)
                ->filter()
                ->all();

            if (! empty($ids)) {
                $product->tags()->syncWithoutDetaching($ids);
            }
        }
    }
}

