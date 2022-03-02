<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\MealType;
use App\Models\Package;
use App\Models\PackageMeal;
use Illuminate\Database\Seeder;

class PackageMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $meal_types = MealType::all();
        $packages = Package::all();
        foreach ($packages as $package) {
            // loop الفطر والعشاء
            foreach ($meal_types as $meal_type) {
                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Saturday'; // اليوم
                    $data['week'] = 1; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Sunday'; // اليوم
                    $data['week'] = 1; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Monday'; // اليوم
                    $data['week'] = 1; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Tuesday'; // اليوم
                    $data['week'] = 1; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Wednesday'; // اليوم
                    $data['week'] = 1; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Thursday'; // اليوم
                    $data['week'] = 1; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Friday'; // اليوم
                    $data['week'] = 1; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Saturday'; // اليوم
                    $data['week'] = 2; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Sunday'; // اليوم
                    $data['week'] = 2; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Monday'; // اليوم
                    $data['week'] = 2; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Tuesday'; // اليوم
                    $data['week'] = 2; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Wednesday'; // اليوم
                    $data['week'] = 2; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Thursday'; // اليوم
                    $data['week'] = 2; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }

                $meals = Meal::inRandomOrder()->take(2)->get();

                foreach ($meals as $meal) {
                    $data['meal_id'] = $meal->id;   // شيش ر راندوم تو
                    $data['package_id'] = $package->id; // باقة الرجيم
                    $data['meal_type_id'] = $meal_type->id;  //الفطار
                    $data['day'] = 'Friday'; // اليوم
                    $data['week'] = 2; // رقم الاسبوع
                    PackageMeal::updateOrCreate($data);
                }


            }
        }
    }
}
