<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FactoryProductController extends Controller
{
    public function index(Request $request)
    {
        $factory = $request->user()->factory;

        $products = $factory
            ? $factory->products()->latest()->paginate(15)
            : Product::whereRaw('1 = 0')->paginate(15);

        return view('factory.products.index', [
            'factory' => $factory,
            'products' => $products,
        ]);
    }

    public function create(Request $request)
    {
        $factory = $request->user()->factory;

        return view('factory.products.create', [
            'factory' => $factory,
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $factory = $request->user()->factory;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'product_category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'status' => ['required', 'integer', 'in:0,1,2'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:3'],
            'unit' => ['nullable', 'string', 'max:50'],
            'price_type' => ['required', 'in:fixed,on_request'],
            'pack_size' => ['nullable', 'integer', 'min:1'],
            'pack_price' => ['nullable', 'numeric', 'min:0'],
            'is_published_storefront' => ['nullable', 'boolean'],
            'is_published_marketplace' => ['nullable', 'boolean'],
            'primary_media_url' => ['nullable', 'string', 'max:500'],
            'media_files.*' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,mp4,webm'],
        ]);

        $slug = str()->slug($data['name']);

        $product = Product::create([
            'factory_id' => $factory->id,
            'product_category_id' => $data['product_category_id'] ?? null,
            'name' => $data['name'],
            'slug' => $slug . '-' . uniqid(),
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'base_price' => $data['base_price'] ?? null,
            'currency' => $data['currency'] ?? 'JOD',
            'unit' => $data['unit'] ?? null,
            'price_type' => $data['price_type'],
            'price' => $data['base_price'] ?? null,
            'pack_size' => $data['pack_size'] ?? null,
            'pack_price' => $data['pack_price'] ?? null,
            'is_published' => (bool) (($data['is_published_storefront'] ?? false) || ($data['is_published_marketplace'] ?? false)),
            'is_published_storefront' => (bool) ($data['is_published_storefront'] ?? false),
            'is_published_marketplace' => (bool) ($data['is_published_marketplace'] ?? false),
        ]);

        $this->syncProductMedia($request, $product, $data['primary_media_url'] ?? null);

        return redirect()
            ->route('factory.products.edit', $product)
            ->with('status', 'product_created');
    }

    public function edit(Request $request, Product $product)
    {
        $factory = $request->user()->factory;

        abort_unless($product->factory_id === $factory?->id, 403);

        return view('factory.products.edit', [
            'factory' => $factory,
            'product' => $product,
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $factory = $request->user()->factory;

        abort_unless($product->factory_id === $factory?->id, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'product_category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'status' => ['required', 'integer', 'in:0,1,2'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:3'],
            'unit' => ['nullable', 'string', 'max:50'],
            'price_type' => ['required', 'in:fixed,on_request'],
            'pack_size' => ['nullable', 'integer', 'min:1'],
            'pack_price' => ['nullable', 'numeric', 'min:0'],
            'is_published_storefront' => ['nullable', 'boolean'],
            'is_published_marketplace' => ['nullable', 'boolean'],
            'primary_media_url' => ['nullable', 'string', 'max:500'],
            'media_files.*' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,mp4,webm'],
        ]);

        $product->update([
            'product_category_id' => $data['product_category_id'] ?? null,
            'name' => $data['name'],
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'base_price' => $data['base_price'] ?? null,
            'currency' => $data['currency'] ?? 'JOD',
            'unit' => $data['unit'] ?? null,
            'price_type' => $data['price_type'],
            'price' => $data['base_price'] ?? $product->price,
            'pack_size' => $data['pack_size'] ?? null,
            'pack_price' => $data['pack_price'] ?? null,
            'is_published' => (bool) (($data['is_published_storefront'] ?? false) || ($data['is_published_marketplace'] ?? false)),
            'is_published_storefront' => (bool) ($data['is_published_storefront'] ?? false),
            'is_published_marketplace' => (bool) ($data['is_published_marketplace'] ?? false),
        ]);

        $this->syncProductMedia($request, $product, $data['primary_media_url'] ?? null);

        return redirect()
            ->route('factory.products.edit', $product)
            ->with('status', 'product_updated');
    }

    protected function syncProductMedia(Request $request, Product $product, ?string $primaryUrl = null): void
    {
        if ($primaryUrl) {
            ProductMedia::updateOrCreate(
                ['product_id' => $product->id, 'position' => 0],
                [
                    'type' => 'image',
                    'url' => $primaryUrl,
                ],
            );
        }

        if ($request->hasFile('media_files')) {
            $currentMax = $product->media()->max('position') ?? 0;

            foreach ($request->file('media_files') as $index => $file) {
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

                $product->media()->create([
                    'type' => $type,
                    'url' => Storage::url($path),
                    'position' => $currentMax + $index + 1,
                ]);
            }
        }
    }
}
