<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class DaysSeeder extends Seeder
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
                'name_ar' => 'السبت',
                'name_en' => 'Saturday',
            ],
            [
                'name_ar' => 'الاحد',
                'name_en' => 'Sunday',
            ],
            [
                'name_ar' => 'الاثنين',
                'name_en' => 'Monday',
            ],
            [
                'name_ar' => 'الثلاثاء',
                'name_en' => 'Tuesday',
            ],
            [
                'name_ar' => 'الاربعاء',
                'name_en' => 'Wednesday',
            ],
            [
                'name_ar' => 'الخميس',
                'name_en' => 'Thursday',
            ],
            [
                'name_ar' => 'الجمعة',
                'name_en' => 'Friday',
            ],
        ];
        foreach ($data as $get) {
            Day::updateOrCreate($get);
        }
    }
}
