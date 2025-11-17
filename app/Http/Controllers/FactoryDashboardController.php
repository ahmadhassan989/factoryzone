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

        return view('factory.dashboard', [
            'user' => $user,
            'factory' => $factory,
            'products' => $products,
            'inquiries' => $inquiries,
        ]);
    }
}

