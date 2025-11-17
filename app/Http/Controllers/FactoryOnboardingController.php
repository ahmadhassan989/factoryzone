<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FactoryOnboardingController extends Controller
{
    public function create()
    {
        return view('factories.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'factory_name' => ['required', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'zone_id' => ['nullable', 'integer', 'exists:zones,id'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $factory = Factory::create([
            'zone_id' => $data['zone_id'] ?? null,
            'name' => $data['factory_name'],
            'legal_name' => $data['legal_name'] ?? null,
            'slug' => str()->slug($data['factory_name']) . '-' . uniqid(),
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'contact_name' => $data['contact_name'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'] ?? null,
            'status' => 'pending',
        ]);

        $user = User::create([
            'name' => $data['contact_name'],
            'email' => $data['contact_email'],
            'password' => Hash::make($data['password']),
            'factory_id' => $factory->id,
            'role' => 'factory_owner',
        ]);

        return redirect()->route('factories.thankyou');
    }
}
