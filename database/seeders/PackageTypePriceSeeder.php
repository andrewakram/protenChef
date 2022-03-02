<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageType;
use App\Models\PackageTypePrice;
use Illuminate\Database\Seeder;

class PackageTypePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = Package::all();
        $package_types = PackageType::all();
        foreach ($packages as $package) {
            foreach ($package_types as $type) {
                $price_data['price'] = $type->id . 200;
                $price_data['package_id'] = $package->id;
                $price_data['package_type_id'] = $type->id;
                PackageTypePrice::updateOrCreate($price_data);
            }
        }
    }
}
