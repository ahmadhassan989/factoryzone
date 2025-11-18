<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $tags = [
            ['name' => 'Export ready', 'slug' => 'export-ready'],
            ['name' => 'ISO certified', 'slug' => 'iso-certified'],
            ['name' => 'Private label', 'slug' => 'private-label'],
        ];

        foreach ($tags as $data) {
            Tag::updateOrCreate(
                ['slug' => $data['slug']],
                ['name' => $data['name']],
            );
        }
    }
}

