<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = [
            [
                'code' => 'FOOD',
                'name_en' => 'Food & Beverage Manufacturing',
                'name_ar' => 'تصنيع الأغذية والمشروبات',
            ],
            [
                'code' => 'PLASTICS',
                'name_en' => 'Plastics & Packaging',
                'name_ar' => 'الصناعات البلاستيكية والتغليف',
            ],
            [
                'code' => 'TEXTILES',
                'name_en' => 'Textiles & Garments',
                'name_ar' => 'المنسوجات والملابس الجاهزة',
            ],
            [
                'code' => 'CHEMICALS',
                'name_en' => 'Chemicals & Detergents',
                'name_ar' => 'الكيماويات والمنظفات',
            ],
            [
                'code' => 'METAL',
                'name_en' => 'Metal Works & Fabrication',
                'name_ar' => 'تشكيل المعادن والمنتجات المعدنية',
            ],
            [
                'code' => 'PHARMA',
                'name_en' => 'Pharmaceuticals & Medical Supplies',
                'name_ar' => 'الأدوية والمستلزمات الطبية',
            ],
            [
                'code' => 'AUTO_PARTS',
                'name_en' => 'Automotive Parts & Components',
                'name_ar' => 'قطع غيار السيارات والمكونات',
            ],
        ];

        foreach ($industries as $data) {
            Industry::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name_en' => $data['name_en'],
                    'name_ar' => $data['name_ar'],
                    'status' => 1,
                ],
            );
        }
    }
}

