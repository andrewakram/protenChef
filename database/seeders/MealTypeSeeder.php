<?php

namespace Database\Seeders;

use App\Models\MealType;
use Illuminate\Database\Seeder;

class MealTypeSeeder extends Seeder
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
                'title_ar' => 'فطور',
                'title_en' => 'breakfast',
                'image' => 'ftor.png',
                'type' => 'main',
            ],
            [
                'title_ar' => 'غداء',
                'title_en' => 'lunch',
                'image' => 'lunch.png',
                'type' => 'main',
            ],
            [
                'title_ar' => 'عشاء',
                'title_en' => 'dinner',
                'image' => 'dinner.png',
                'type' => 'main',
            ],
            [
                'title_ar' => 'سلطة',
                'title_en' => 'Salad',
                'image' => 'Salad.png',
                'type' => 'main',
            ],
            [
                'title_ar' => 'فاكهة',
                'title_en' => 'fruit',
                'image' => 'fruit.png',
                'type' => 'sub',
            ],
            [
                'title_ar' => 'حلوى',
                'title_en' => 'sweets',
                'image' => 'sweets.png',
                'type' => 'sub',
            ],
            [
                'title_ar' => 'سناكس',
                'title_en' => 'snakes',
                'image' => 'sweets.png',
                'type' => 'sub',
            ],

        ];
        foreach ($data as $get) {
            MealType::updateOrCreate($get);
        }
    }
}
