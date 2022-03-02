<?php

namespace Database\Seeders;

use App\Models\PackageType;
use Illuminate\Database\Seeder;

class PackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title_ar' => '28 يوم',
                'title_en' => '28 days',
                'days_count' => '28'
            ],
            [
                'title_ar' => '20 يوم ( سبت - اربعاء )',
                'title_en' => '20 days ( Saturday - wednesday )',
                'days_count' => '20'
            ],
            [
                'title_ar' => '20 يوم ( أحد - خميس )',
                'title_en' => '20 days ( sunday - Thursday )',
                'days_count' => '20'
            ],
            [
                'title_ar' => '7 يوم',
                'title_en' => '7 days',
                'days_count' => '7'
            ],

        ];
        foreach ($data as $get) {
            PackageType::updateOrCreate($get);
        }
    }
}
