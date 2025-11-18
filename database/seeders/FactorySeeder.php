<?php

namespace Database\Seeders;

use App\Models\Factory;
use App\Models\Industry;
use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $food = Industry::where('code', 'FOOD')->first();
        $plastics = Industry::where('code', 'PLASTICS')->first();
        $textiles = Industry::where('code', 'TEXTILES')->first();

        $sahab = Zone::where('name', 'Sahab Industrial City')->first();
        $alHassan = Zone::where('name', 'Al Hassan Industrial Estate')->first();

        $factories = [
            [
                'name_en' => 'Jordan Fresh Foods',
                'name_ar' => 'الأردن للأغذية الطازجة',
                'slug' => 'jordan-fresh-foods',
                'zone_id' => $sahab?->id,
                'industry_id' => $food?->id,
                'country' => 'Jordan',
                'city' => 'Sahab',
                'contact_name' => 'Ahmad Musa',
                'contact_email' => 'contact@jordanfreshfoods.com',
            ],
            [
                'name_en' => 'Amman Plastics',
                'name_ar' => 'عمّان للبلاستيك',
                'slug' => 'amman-plastics',
                'zone_id' => $alHassan?->id,
                'industry_id' => $plastics?->id,
                'country' => 'Jordan',
                'city' => 'Irbid',
                'contact_name' => 'Sara Al-Hassan',
                'contact_email' => 'info@ammanplastics.com',
            ],
            [
                'name_en' => 'Desert Textiles',
                'name_ar' => 'صحارى للمنسوجات',
                'slug' => 'desert-textiles',
                'zone_id' => $sahab?->id,
                'industry_id' => $textiles?->id,
                'country' => 'Jordan',
                'city' => 'Amman',
                'contact_name' => 'Khaled Nassar',
                'contact_email' => 'sales@deserttextiles.com',
            ],
        ];

        foreach ($factories as $data) {
            Factory::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'legal_name' => null,
                    'contact_phone' => null,
                    'status' => 'approved',
                ]),
            );
        }
    }
}

