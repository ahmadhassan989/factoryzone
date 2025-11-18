<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $now = Carbon::now();
        $from = $now->copy()->subDays(30);

        $metrics = [
            'factories_total' => Factory::count(),
            'factories_approved' => Factory::where('status', 'approved')->count(),
            'factories_pending' => Factory::where('status', 'pending')->count(),
            'products_total' => Product::count(),
            'products_marketplace_published' => Product::where('is_published_marketplace', true)->count(),
            'products_storefront_published' => Product::where('is_published_storefront', true)->count(),
            'inquiries_last_30_days' => Inquiry::whereBetween('created_at', [$from, $now])->count(),
            'inquiries_new' => Inquiry::where('status', 'new')->count(),
            'orders_total' => Order::count(),
            'orders_pending' => Order::where('status', 'pending')->count(),
            'orders_completed' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'from' => $from,
            'to' => $now,
        ]);
    }
}
