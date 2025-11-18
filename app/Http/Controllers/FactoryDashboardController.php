<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FactoryDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $factory = $user?->factory;

        $products = $factory
            ? $factory->products()->latest()->take(10)->get()
            : collect();

        $inquiries = $factory
            ? $factory->inquiries()->latest()->take(10)->get()
            : collect();

        $metrics = [
            'products_total' => $factory ? $factory->products()->count() : 0,
            'products_storefront_published' => $factory
                ? $factory->products()->where('is_published_storefront', true)->count()
                : 0,
            'products_marketplace_published' => $factory
                ? $factory->products()->where('is_published_marketplace', true)->count()
                : 0,
            'inquiries_new' => $factory
                ? $factory->inquiries()->where('status', 'new')->count()
                : 0,
            'inquiries_in_review' => $factory
                ? $factory->inquiries()->where('status', 'in_review')->count()
                : 0,
            'inquiries_closed' => $factory
                ? $factory->inquiries()->where('status', 'closed')->count()
                : 0,
            'orders_pending' => $factory
                ? $factory->orders()->where('status', 'pending')->count()
                : 0,
            'orders_confirmed' => $factory
                ? $factory->orders()->where('status', 'confirmed')->count()
                : 0,
            'orders_completed' => $factory
                ? $factory->orders()->where('status', 'completed')->count()
                : 0,
        ];

        return view('factory.dashboard', [
            'user' => $user,
            'factory' => $factory,
            'products' => $products,
            'inquiries' => $inquiries,
            'metrics' => $metrics,
        ]);
    }
}
