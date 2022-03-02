<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
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
                'title_ar' => 'الحق العرض و متفوتوش',
                'title_en' => 'Display right and misstoush',
                'body_ar' => 'وجبة شاورما وبطاطس وبيبس كومبو وجبة شاورما وبطاطس وبيبس كومبو وجبة شاورما وبطاطس وبيبس كومبو',
                'body_en' => 'Shawarma meal, potatoes and peps combo meal Shawarma meal, potatoes and peps combo meal Shawarma meal, potatoes and peps combo',
                'image' => 'first_offer.png',
                'date' => '2022-03-02',
            ],
            [
                'title_ar' => 'الحق العرض و متفوتوش',
                'title_en' => 'Display right and misstoush',
                'body_ar' => 'وجبة شاورما وبطاطس وبيبس كومبو وجبة شاورما وبطاطس وبيبس كومبو وجبة شاورما وبطاطس وبيبس كومبو',
                'body_en' => 'Shawarma meal, potatoes and peps combo meal Shawarma meal, potatoes and peps combo meal Shawarma meal, potatoes and peps combo',
                'image' => 'second_offer.png',
                'date' => '2022-03-02',
            ],
        ];
        foreach ($data as $get) {
            Offer::updateOrCreate($get);
        }
    }
}
