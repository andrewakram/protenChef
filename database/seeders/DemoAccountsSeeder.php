<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//super admin account
        $exists_super_admin = Admin::where('type', 'super')->first();
        if (!$exists_super_admin) {
            Admin::updateOrCreate([
                'name' => 'super admin',
                'type' => 'super',
                'email' => 'super@demo.com',
                'phone' => '01094641332',
                'password' => '123456',
            ]);
        }

//admin account

        $exists_admin = Admin::where('type', 'admin')->first();
        if (!$exists_admin) {
            Admin::updateOrCreate([
                'name' => 'admin',
                'type' => 'admin',
                'email' => 'admin@demo.com',
                'phone' => '01111651415',
                'password' => '123456',
            ]);
        }

        //customer account
        $exists_cust = User::where('email', 'customer@demo.com')->first();
        if (!$exists_cust) {
            $customer = User::updateOrCreate([
                'name' => 'customer demo',
                'email' => 'customer@demo.com',
                'phone' => '01201636129',
                'password' => '123456',
                'gender' => 'male',
                'age' => '26',
                'weight' => '76',
                'height' => '176',
                'active' => 1,
                'fcm_token' => 'sadsdadklsadsalndksaljksaldsad',
                'provider' => 'other',
            ]);
        }
        //ngar account
        $exists_cust = User::where('phone', '01030407100')->first();
        if (!$exists_cust) {
            $customer = User::updateOrCreate([
                'name' => 'mostafa elnagar',
                'email' => 'mostafa@demo.com',
                'phone' => '01030407100',
                'password' => '123456',
                'gender' => 'male',
                'age' => '26',
                'weight' => '76',
                'height' => '176',
                'active' => 1,
                'fcm_token' => '05f92d71a159c9a8',
                'provider' => 'other',
            ]);
        }
    }
}
