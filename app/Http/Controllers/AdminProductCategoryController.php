<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::query()
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if (! $data['slug'] ?? false) {
            $data['slug'] = str()->slug($data['name']);
        }

        ProductCategory::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'category_created');
    }

    public function update(Request $request, ProductCategory $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if (! $data['slug'] ?? false) {
            $data['slug'] = str()->slug($data['name']);
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'category_updated');
    }

    public function destroy(ProductCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'category_deleted');
    }
}

