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
        $meal_types = MealType::all();
        foreach ($prices as $price) {
            foreach ($meal_types as $meal_type) {
                $data['package_type_price_id'] = $price->id;
                $data['meal_type_id'] = $meal_type->id;
                if ($meal_type->type == 'sub') {
                    $data['price'] = $meal_type->id . 20;
                }
                PackageMealType::updateOrCreate($data);
            }
        }
    }
}
