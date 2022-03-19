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

//        اشتراك شهر 28 يوم كل يوم
//شهر 24 يوم بدون جمعه
//شهر 20 يوم بدون جمعه وسبت
//
//اشتراك اسبوع 5 ايام بدون جمعه وسبت
        $data = [
            [
                'id' => 1,
                'title_ar' => '28 يوم (كل يوم )',
                'title_en' => '28 days ( every day )',
                'days_count' => '27'
            ],
            [
                'id' => 2,
                'title_ar' => '24 يوم ( شهر بدون جمعة )',
                'title_en' => '24 days ( month without Friday )',
                'days_count' => '28'
            ],
            [
                'id' => 3,
                'title_ar' => '20 يوم ( شهر بدون جمعة و سبت )',
                'title_en' => '20 days ( month without Friday and Saturday )',
                'days_count' => '29'
            ],
            [
                'id' => 4,
                'title_ar' => '5 أيام ( اسبوع بدون جمعة و سبت )',
                'title_en' => '5 days ( week without Friday and Saturday )',
                'days_count' => '6'
            ]
        ];
        foreach ($data as $get) {
            PackageType::updateOrCreate($get);
        }
    }
}
