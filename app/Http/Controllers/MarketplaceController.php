<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function factories(Request $request)
    {
        $query = Factory::query()
            ->with('zone')
            ->where('status', 'approved');

        if ($request->filled('zone_id')) {
            $query->where('zone_id', $request->integer('zone_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('industries', 'like', '%' . $search . '%');
            });
        }

        $factories = $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($factories);
        }

        return view('marketplace.factories', [
            'factories' => $factories,
        ]);
    }

    public function products(Request $request)
    {
        $query = Product::query()
            ->with(['factory.zone', 'category', 'tags'])
            ->where('is_published_marketplace', true);

        if ($request->filled('category_id')) {
            $query->where('product_category_id', $request->integer('category_id'));
        }

        if ($request->filled('zone_id')) {
            $query->whereHas('factory', function ($q) use ($request) {
                $q->where('zone_id', $request->integer('zone_id'));
            });
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $products = $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($products);
        }

        return view('marketplace.products', [
            'products' => $products,
        ]);
    }
}
