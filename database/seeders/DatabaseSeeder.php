<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

//        $this->call(ScreenSeeder::class);
//        $this->call(SliderSeeder::class);
//        $this->call(PackageSeeder::class);
//        $this->call(OfferSeeder::class);
//        $this->call(PackageTypeSeeder::class);
//        $this->call(MealTypeSeeder::class);
//        $this->call(MealSeeder::class);
//        $this->call(PageSeeder::class);
          $this->call(SettingSeeder::class);
//        $this->call(CouponSeeder::class);
//        $this->call(DemoAccountsSeeder::class);
//        $this->call(PackageTypePriceSeeder::class);
//        $this->call(PackageMealTypeSeeder::class);
//        $this->call(PackageMealSeeder::class);
//        $this->call(LocationSeeder::class);
//        $this->call(NotificationSeeder::class);
    }
}
