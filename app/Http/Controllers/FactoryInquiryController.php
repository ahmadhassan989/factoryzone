<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FactoryInquiryController extends Controller
{
    public function index(Request $request)
    {
        $factory = $request->user()->factory;

        $query = $factory
            ? $factory->inquiries()->with('product')->latest()
            : null;

        if ($query && $request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $inquiries = $query ? $query->paginate(20) : collect();

        return view('factory.inquiries.index', [
            'factory' => $factory,
            'inquiries' => $inquiries,
        ]);
    }

    public function updateStatus(Request $request, int $inquiryId): RedirectResponse
    {
        $factory = $request->user()->factory;

        $data = $request->validate([
            'status' => ['required', 'in:new,in_review,closed'],
        ]);

        if (! $factory) {
            abort(403);
        }

        $inquiry = $factory->inquiries()->where('id', $inquiryId)->firstOrFail();
        $inquiry->update(['status' => $data['status']]);

        return redirect()
            ->route('factory.inquiries.index', $request->only('status'))
            ->with('status', 'inquiry_status_updated');
    }
}

