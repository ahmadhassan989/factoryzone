<?php

namespace Database\Seeders;

use App\Models\Factory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Super admin
        User::updateOrCreate(
            ['email' => 'admin@factoryzone.test'],
            [
                'name' => 'Platform Admin',
                'password' => 'password',
                'factory_id' => null,
                'role' => 'super_admin',
            ],
        );

        // Create a couple of sample factories with owners
        $factories = Factory::all();

        foreach ($factories as $factory) {
            User::updateOrCreate(
                ['email' => 'owner+' . $factory->id . '@factoryzone.test'],
                [
                    'name' => $factory->name_en ?? $factory->name,
                    'password' => 'password',
                    'factory_id' => $factory->id,
                    'role' => 'factory_owner',
                ],
            );
        }

        // Sample buyer
        User::updateOrCreate(
            ['email' => 'buyer@factoryzone.test'],
            [
                'name' => 'Sample Buyer',
                'password' => 'password',
                'factory_id' => null,
                'role' => 'buyer',
            ],
        );
    }
}

