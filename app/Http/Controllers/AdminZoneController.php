<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::query()
            ->withCount('factories')
            ->orderBy('name')
            ->get();

        return view('admin.zones.index', [
            'zones' => $zones,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Zone::create($data);

        return redirect()
            ->route('admin.zones.index')
            ->with('status', 'zone_created');
    }

    public function update(Request $request, Zone $zone): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $zone->update($data);

        return redirect()
            ->route('admin.zones.index')
            ->with('status', 'zone_updated');
    }

    public function destroy(Zone $zone): RedirectResponse
    {
        $zone->delete();

        return redirect()
            ->route('admin.zones.index')
            ->with('status', 'zone_deleted');
    }
}

