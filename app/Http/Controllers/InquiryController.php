<?php

namespace App\Http\Controllers;

use App\Mail\NewInquiryNotification;
use App\Models\Factory;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'factory_id' => ['required', 'integer', 'exists:factories,id'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'buyer_name' => ['nullable', 'string', 'max:255'],
            'buyer_email' => ['nullable', 'email', 'max:255'],
            'buyer_phone' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'message' => ['nullable', 'string'],
        ]);

        $factory = Factory::findOrFail($data['factory_id']);
        $product = null;

        if (! empty($data['product_id'])) {
            $product = Product::where('factory_id', $factory->id)
                ->where('id', $data['product_id'])
                ->firstOrFail();
        }

        $source = $request->getHost() === config('app.url') ? 'marketplace' : 'storefront';

        $inquiry = Inquiry::create([
            'factory_id' => $factory->id,
            'product_id' => $product?->id,
            'buyer_name' => $data['buyer_name'] ?? null,
            'buyer_email' => $data['buyer_email'] ?? null,
            'buyer_phone' => $data['buyer_phone'] ?? null,
            'quantity' => $data['quantity'] ?? null,
            'message' => $data['message'] ?? null,
            'source' => $source,
            'status' => 'new',
        ]);

        if ($factory->contact_email) {
            Mail::to($factory->contact_email)->send(
                new NewInquiryNotification($factory, $inquiry, $product)
            );
        }

        return back()->with('status', 'inquiry_submitted');
    }
}
