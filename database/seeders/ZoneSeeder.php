<?php

namespace Database\Seeders;

use App\Models\Screen;
use App\Models\Slider;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = '(25.932973423525855, 39.762440978820116),(24.441770488021834, 38.433095275695116),(24.08119487585833, 41.454335510070116)';
        foreach (explode('),(', trim($value, '()')) as $index => $single_array) {
            if ($index == 0) {
                $lastcord = explode(',', $single_array);
            }
            $coords = explode(',', $single_array);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $data = [
            [
                'name' => 'ksa',
                'coordinates' => new Polygon([new LineString($polygon)]),
                'restaurant_wise_topic' => 'zone_5_restaurant',
                'customer_wise_topic' => 'zone_5_customer',
                'deliveryman_wise_topic' => 'zone_5_delivery_man',
            ],
        ];
        foreach ($data as $get) {
            Zone::updateOrCreate($get);
        }
    }
}
