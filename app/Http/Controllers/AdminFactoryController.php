<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminFactoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Factory::query()
            ->with('zone')
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('legal_name', 'like', '%' . $search . '%');
            });
        }

        $factories = $query->paginate(20);

        return view('admin.factories.index', [
            'factories' => $factories,
        ]);
    }

    public function updateStatus(Request $request, Factory $factory): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,suspended'],
        ]);

        $factory->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('admin.factories.index', $request->only('status', 'search'))
            ->with('status', 'factory_status_updated');
    }
}

