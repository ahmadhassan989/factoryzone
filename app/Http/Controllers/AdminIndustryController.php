<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminIndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::query()
            ->orderBy('name_en')
            ->get();

        return view('admin.industries.index', [
            'industries' => $industries,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:industries,code'],
            'name_en' => ['required', 'string', 'max:150'],
            'name_ar' => ['required', 'string', 'max:150'],
            'status' => ['nullable', 'integer', 'in:0,1'],
        ]);

        Industry::create([
            'code' => $data['code'],
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'status' => $data['status'] ?? 1,
        ]);

        return redirect()
            ->route('admin.industries.index')
            ->with('status', 'industry_created');
    }

    public function update(Request $request, Industry $industry): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:industries,code,' . $industry->id],
            'name_en' => ['required', 'string', 'max:150'],
            'name_ar' => ['required', 'string', 'max:150'],
            'status' => ['nullable', 'integer', 'in:0,1'],
        ]);

        $industry->update([
            'code' => $data['code'],
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'status' => $data['status'] ?? 1,
        ]);

        return redirect()
            ->route('admin.industries.index')
            ->with('status', 'industry_updated');
    }

    public function destroy(Industry $industry): RedirectResponse
    {
        $industry->delete();

        return redirect()
            ->route('admin.industries.index')
            ->with('status', 'industry_deleted');
    }
}

