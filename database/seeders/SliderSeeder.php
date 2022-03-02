<?php

namespace Database\Seeders;

use App\Models\Screen;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
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
                'title' => 'first_slider',
                'url' => 'https://www.google.com/?hl=ar',
                'image' => 'first_slider.png',
            ],
            [
                'title' => 'second_slider',
                'url' => 'https://www.google.com/?hl=ar',
                'image' => 'second_slider.png',
            ],
        ];
        foreach ($data as $get) {
            Slider::updateOrCreate($get);
        }
    }
}
