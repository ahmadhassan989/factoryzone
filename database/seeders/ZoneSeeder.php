<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $zones = [
            ['name' => 'Al Hassan Industrial Estate', 'region' => 'Irbid', 'city' => 'Irbid'],
            ['name' => 'Al Hussein Bin Abdullah II Industrial City', 'region' => 'Karak', 'city' => 'Karak'],
            ['name' => 'Sahab Industrial City', 'region' => 'Amman', 'city' => 'Sahab'],
            ['name' => 'Aqaba International Industrial Estate', 'region' => 'Aqaba', 'city' => 'Aqaba'],
        ];

        foreach ($zones as $data) {
            Zone::updateOrCreate(
                ['name' => $data['name']],
                [
                    'region' => $data['region'],
                    'city' => $data['city'],
                    'notes' => null,
                ],
            );
        }
    }
}

