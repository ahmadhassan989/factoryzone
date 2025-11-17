<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use Illuminate\Http\Request;

class FactoryStorefrontController extends Controller
{
    public function show(Request $request, Factory $factory)
    {
        $products = $factory->products()
            ->where('is_published_storefront', true)
            ->latest()
            ->paginate(12);

        return view('storefront.show', [
            'factory' => $factory,
            'products' => $products,
        ]);
    }
}

