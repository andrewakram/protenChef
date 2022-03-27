<?php

namespace Database\Seeders;

use App\Models\MealType;
use App\Models\PackageMealType;
use App\Models\PackageTypePrice;
use Illuminate\Database\Seeder;

class PackageMealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices = PackageTypePrice::all();

        foreach ($prices as $price) {
            // main meal types
            $main_meal_types = MealType::where('type', 'main')->get();
            if ($main_meal_types) {
                foreach ($main_meal_types as $meal_type) {
                    $data['package_type_price_id'] = $price->id;
                    $data['meal_type_id'] = $meal_type->id;
                    PackageMealType::updateOrCreate($data);
                }
            }


            // additional meal types
            $additional_meal_types = MealType::where('type', 'sub')->get();
            if ($additional_meal_types) {
                foreach ($additional_meal_types as $ad_meal_type) {
                    $additionaldata['package_type_price_id'] = $price->id;
                    $additionaldata['meal_type_id'] = $ad_meal_type->id;
                    $additionaldata['price'] = $ad_meal_type->id . 20;
                    PackageMealType::updateOrCreate($additionaldata);
                }
            }
        }
    }
}
