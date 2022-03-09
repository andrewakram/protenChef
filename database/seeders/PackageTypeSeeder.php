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
                'id' => 1,
                'title_ar' => '28 يوم ( شهر )',
                'title_en' => '28 days ( month )',
                'days_count' => '28'
            ],
            [
                'id' => 2,
                'title_ar' => '24 يوم ( شهر بدون جمعة )',
                'title_en' => '24 days ( month without Friday )',
                'days_count' => '24'
            ],
            [
                'id' => 3,
                'title_ar' => '24 يوم ( شهر بدون سبت )',
                'title_en' => '24 days ( month without Saturday )',
                'days_count' => '24'
            ],
            [
                'id' => 4,
                'title_ar' => '20 يوم ( شهر بدون جمعة و سبت )',
                'title_en' => '20 days ( month without Friday and Saturday )',
                'days_count' => '20'
            ],
            [
                'id' => 5,
                'title_ar' => '14 يوم ( اسبوعين )',
                'title_en' => '14 days ( Two weeks )',
                'days_count' => '14'
            ],
            [
                'id' => 6,
                'title_ar' => '12 يوم ( اسبوعين بدون جمعة )',
                'title_en' => '12 days ( Two weeks without Friday )',
                'days_count' => '12'
            ],
            [
                'id' => 7,
                'title_ar' => '12 يوم ( اسبوعين بدون سبت )',
                'title_en' => '12 days ( two weeks without sabbath )',
                'days_count' => '12'
            ],
            [
                'id' => 8,
                'title_ar' => '10 أيام ( اسبوعين بدون جمعة و سبت )',
                'title_en' => '10 days ( Two weeks without Friday and Saturday )',
                'days_count' => '10'
            ],
            [
                'id' => 9,
                'title_ar' => '7 أيام ( اسبوع )',
                'title_en' => '7 days ( week )',
                'days_count' => '7'
            ],
            [
                'id' => 10,
                'title_ar' => '6 أيام ( اسبوع بدون جمعة )',
                'title_en' => '6 days ( week without Friday )',
                'days_count' => '6'
            ],
            [
                'id' => 11,
                'title_ar' => '6 أيام ( اسبوع بدون سبت )',
                'title_en' => '6 days ( week without Saturday )',
                'days_count' => '6'
            ],
            [
                'id' => 12,
                'title_ar' => '5 أيام ( اسبوع بدون جمعة و سبت )',
                'title_en' => '5 days ( week without Friday and Saturday )',
                'days_count' => '5'
            ],
            [
                'id' => 13,
                'title_ar' => 'يوم ( وجبة اليوم الواحد )',
                'title_en' => 'day ( One-day meal )',
                'days_count' => '1'
            ],

        ];
        foreach ($data as $get) {
            PackageType::updateOrCreate($get);
        }
    }
}
