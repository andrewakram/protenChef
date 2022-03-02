<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
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
                'code' => 'proten50',
                'type' => 'fixed',
                'amount' => '50',
                'min_order_total' => '100',
                'expired_at' => '2022-03-22',
            ],
            [
                'code' => 'chef70',
                'type' => 'fixed',
                'amount' => '70',
                'min_order_total' => '200',
                'expired_at' => '2022-03-25',
            ],
            [
                'code' => 'talabat20',
                'type' => 'percent',
                'amount' => '20',
                'min_order_total' => null,
                'expired_at' => '2022-05-30',
            ],
        ];
        foreach ($data as $get) {
            Coupon::updateOrCreate($get);
        }
    }
}
