<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FactoryProfileController extends Controller
{
    public function edit(Request $request)
    {
        $factory = $request->user()->factory;

        return view('factory.profile.edit', [
            'factory' => $factory,
            'zones' => Zone::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $factory = $request->user()->factory;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'zone_id' => ['nullable', 'integer', 'exists:zones,id'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'industries' => ['nullable', 'string'],
            'capabilities' => ['nullable', 'string'],
            'certifications' => ['nullable', 'string'],
            'google_maps_url' => ['nullable', 'url'],
            'preferred_locale' => ['nullable', 'in:en,ar'],
        ]);

        $factory->update($data);

        return redirect()
            ->route('factory.profile.edit')
            ->with('status', 'factory_profile_updated');
    }
}

