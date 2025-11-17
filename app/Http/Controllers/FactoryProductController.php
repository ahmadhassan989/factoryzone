<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
            'price_type' => ['required', 'in:fixed,on_request'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_published_storefront' => ['nullable', 'boolean'],
            'is_published_marketplace' => ['nullable', 'boolean'],
        ]);

        $slug = str()->slug($data['name']);

        $product = Product::create([
            'factory_id' => $factory->id,
            'product_category_id' => $data['product_category_id'] ?? null,
            'name' => $data['name'],
            'slug' => $slug . '-' . uniqid(),
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'price_type' => $data['price_type'],
            'price' => $data['price'] ?? null,
            'is_published_storefront' => (bool) ($data['is_published_storefront'] ?? false),
            'is_published_marketplace' => (bool) ($data['is_published_marketplace'] ?? false),
        ]);

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
            'price_type' => ['required', 'in:fixed,on_request'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_published_storefront' => ['nullable', 'boolean'],
            'is_published_marketplace' => ['nullable', 'boolean'],
        ]);

        $product->update([
            'product_category_id' => $data['product_category_id'] ?? null,
            'name' => $data['name'],
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'price_type' => $data['price_type'],
            'price' => $data['price'] ?? null,
            'is_published_storefront' => (bool) ($data['is_published_storefront'] ?? false),
            'is_published_marketplace' => (bool) ($data['is_published_marketplace'] ?? false),
        ]);

        return redirect()
            ->route('factory.products.edit', $product)
            ->with('status', 'product_updated');
    }
}

