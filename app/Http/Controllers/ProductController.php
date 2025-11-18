<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMedia;
use App\Models\ProductTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $factory = $request->user()->factory;

        return view('products.create', [
            'factory' => $factory,
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $factory = $request->user()->factory;

        $data = $request->validate([
            'product_category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'sku' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:draft,active,inactive'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:3'],
            'unit' => ['nullable', 'string', 'max:50'],
            'is_published' => ['nullable', 'boolean'],
            'is_published_marketplace' => ['nullable', 'boolean'],

            'translations.*.name' => ['nullable', 'string', 'max:255'],
            'translations.*.short_description' => ['nullable', 'string'],
            'translations.*.long_description' => ['nullable', 'string'],

            'images.*' => ['nullable', 'file', 'image', 'max:5120'],
            'files.*' => ['nullable', 'file', 'max:5120'],
        ]);

        $supportedLocales = array_keys(config('locales.supported', []));
        $defaultLocale = $supportedLocales[0] ?? 'en';

        $translationsInput = $request->input('translations', []);
        $defaultName = $translationsInput[$defaultLocale]['name'] ?? null;
        $defaultShortDescription = $translationsInput[$defaultLocale]['short_description'] ?? null;

        $attributesArray = [];
        foreach ((array) $request->input('attributes', []) as $row) {
            $key = trim($row['key'] ?? '');
            $value = trim($row['value'] ?? '');

            if ($key !== '' && $value !== '') {
                $attributesArray[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }
        }

        $statusMap = [
            'draft' => 0,
            'active' => 1,
            'inactive' => 2,
        ];

        $statusValue = $statusMap[$data['status']] ?? 0;

        $nameForCore = $defaultName ?: 'Untitled product';

        $product = Product::create([
            'factory_id' => $factory->id,
            'product_category_id' => $data['product_category_id'] ?? null,
            'name' => $nameForCore,
            'slug' => Str::slug($nameForCore) . '-' . uniqid(),
            'sku' => $data['sku'] ?? null,
            'description' => $defaultShortDescription,
            'attributes' => $attributesArray,
            'status' => $statusValue,
            'base_price' => $data['base_price'] ?? null,
            'currency' => $data['currency'] ?? null,
            'unit' => $data['unit'] ?? null,
            'price' => $data['base_price'] ?? null,
            'pack_size' => null,
            'pack_price' => null,
            'price_type' => $data['base_price'] !== null ? 'fixed' : 'on_request',
            'is_published' => (bool) ($data['is_published'] ?? false),
            'is_published_storefront' => (bool) ($data['is_published'] ?? false),
            'is_published_marketplace' => (bool) ($data['is_published_marketplace'] ?? false),
        ]);

        foreach (config('locales.supported', []) as $locale => $meta) {
            $t = $translationsInput[$locale] ?? null;
            if (! $t || empty($t['name'])) {
                continue;
            }

            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => $locale,
                'name' => $t['name'],
                'slug' => Str::slug($t['name']),
                'short_description' => $t['short_description'] ?? null,
                'long_description' => $t['long_description'] ?? null,
            ]);
        }

        $position = 0;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (! $file) {
                    continue;
                }

                $path = $file->store('products/' . $product->id, 'public');

                ProductMedia::create([
                    'product_id' => $product->id,
                    'type' => 'image',
                    'url' => Storage::url($path),
                    'position' => $position++,
                ]);
            }
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (! $file) {
                    continue;
                }

                $path = $file->store('products/' . $product->id, 'public');
                $mime = $file->getMimeType();

                $type = str_starts_with($mime, 'image/')
                    ? 'image'
                    : (str_starts_with($mime, 'video/')
                        ? 'video'
                        : ($mime === 'application/pdf' ? 'pdf' : 'file'));

                ProductMedia::create([
                    'product_id' => $product->id,
                    'type' => $type,
                    'url' => Storage::url($path),
                    'position' => $position++,
                ]);
            }
        }

        return redirect()
            ->route('factory.products.index')
            ->with('status', 'product_created');
    }
}

