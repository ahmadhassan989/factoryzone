<?php

namespace Database\Seeders;

use Database\Seeders\IndustrySeeder;
use Database\Seeders\ZoneSeeder;
use Database\Seeders\FactorySeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\ProductTagSeeder;
use Database\Seeders\InquirySeeder;
use Database\Seeders\OrderSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IndustrySeeder::class,
            ZoneSeeder::class,
            FactorySeeder::class,
            UserSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            TagSeeder::class,
            ProductTagSeeder::class,
            InquirySeeder::class,
            OrderSeeder::class,
        ]);
    }
}
