<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
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
                'title_ar' => 'باقة الرجيم',
                'title_en' => 'Diet Package',
                'image' => 'Diet_package.png',
            ],
            [
                'title_ar' => 'باقة الكيتو',
                'title_en' => 'kito package',
                'image' => 'kito_package.png',
            ],
            [
                'title_ar' => 'الباقة الثالثة',
                'title_en' => 'third package',
                'image' => 'third_package.png',
            ],

        ];
        foreach ($data as $get) {
            Package::updateOrCreate($get);
        }
    }
}
