<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
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
                'key' => 'name_ar',
                'value' => 'بروتين شيف',

            ], [
                'key' => 'name_en',
                'value' => 'proten chef',
            ],
            [
                'key' => 'address_ar',
                'value' => 'عنوان شركة بروتين شيف بالكويت',
            ], [
                'key' => 'address_en',
                'value' => 'The address of Protein Chef in Kuwait',
            ],
            [
                'key' => 'working_hours_ar',
                'value' => 'من 9 صباحاً الي 11 صباحاً',
            ], [
                'key' => 'working_hours_en',
                'value' => 'From 9 am to 11 amً',
            ],

            [
                'key' => 'shipp_value',
                'value' => '70',
            ],
            [
                'key' => 'freeze_days',
                'value' => "5",
            ],
            [
                'key' => 'phone_1',
                'value' => '01201636129',

            ], [
                'key' => 'phone_2',
                'value' => '01094641332',

            ], [
                'key' => 'email_1',
                'value' => 'proten_chef@gmail.com',

            ], [
                'key' => 'email_2',
                'value' => 'proten2_chef@gmail.com',

            ], [
                'key' => 'whatsapp',
                'value' => '01094641332',

            ], [
                'key' => 'facebook',
                'value' => 'https://www.facebook.com/',

            ], [
                'key' => 'twitter',
                'value' => 'https://www.facebook.com/',

            ], [
                'key' => 'instagram',
                'value' => 'https://www.facebook.com/',
            ], [
                'key' => 'snapchat',
                'value' => 'https://www.facebook.com/',
            ], [
                'key' => 'youtube',
                'value' => 'https://www.facebook.com/',
            ],
            [
                'key' => 'logo_ar',
                'value' => 'logo.png',
            ], [
                'key' => 'logo_en',
                'value' => 'logo.png',
            ], [
                'key' => 'fav_icon',
                'value' => 'food.ico',
            ],
            [
                'key' => 'default_location',
                'value' => '{"lat":"29.172909419416","lng":"47.76978786947689"}',
            ],

        ];
        foreach ($data as $get) {
            Setting::updateOrCreate($get);
        }
    }
}
