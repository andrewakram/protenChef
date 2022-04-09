<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //'lang',['ar','en']
        //'type',['other','Order','Meal','Offer','Coupon']
        //status >> '1=>order, 2=>order_status, 3=>meal_status, 4=>cancel_order'

        $data = [
            [
                'lang' => 'ar',
                'type' => 'Other',
                'title' => 'عنوان اشعار جديد',
                'body' => 'نص اشعار جديد',

            ], [
                'lang' => 'en',
                'type' => 'Other',
                'title' => 'title new notification',
                'body' => 'body new notification',
            ],
            /////////////////////////////order
            [
                'lang' => 'ar',
                'type' => 'Order',
                'status' => 1,
                'title' => 'عنوان اشعار جديد طلب',
                'body' => 'نص اشعار جديد طلب',
            ], [
                'lang' => 'en',
                'type' => 'Order',
                'status' => 1,
                'title' => 'title new notification Order',
                'body' => 'body new notification Order',
            ],
            [
                'lang' => 'ar',
                'type' => 'Order',
                'status' => 2,
                'title' => 'عنوان اشعار جديد طلب',
                'body' => 'نص اشعار جديد طلب',
            ], [
                'lang' => 'en',
                'type' => 'Order',
                'status' => 2,
                'title' => 'title new notification Order',
                'body' => 'body new notification Order',
            ],
            [
                'lang' => 'ar',
                'type' => 'Order',
                'status' => 3,
                'title' => 'عنوان اشعار جديد طلب',
                'body' => 'نص اشعار جديد طلب',
            ], [
                'lang' => 'en',
                'type' => 'Order',
                'status' => 3,
                'title' => 'title new notification Order',
                'body' => 'body new notification Order',
            ],
            [
                'lang' => 'ar',
                'type' => 'Order',
                'status' => 4,
                'title' => 'عنوان اشعار جديد طلب',
                'body' => 'نص اشعار جديد طلب',
            ], [
                'lang' => 'en',
                'type' => 'Order',
                'status' => 4,
                'title' => 'title new notification Order',
                'body' => 'body new notification Order',
            ]
            //////////////////////////////////========
            ,
            [
                'lang' => 'ar',
                'type' => 'Meal',
                'title' => 'عنوان اشعار جديد وجبة',
                'body' => 'نص اشعار جديد وجبة',
            ], [
                'lang' => 'en',
                'type' => 'Meal',
                'title' => 'title new notification Meal',
                'body' => 'body new notification Meal',
            ],

            [
                'lang' => 'ar',
                'type' => 'Offer',
                'title' => 'عنوان اشعار جديد عرض',
                'body' => 'نص اشعار جديد عرض',
            ], [
                'lang' => 'en',
                'type' => 'Offer',
                'title' => 'title new notification Offer',
                'body' => 'body new notification Offer',
            ],
            [
                'lang' => 'ar',
                'type' => 'Coupon',
                'title' => 'عنوان اشعار جديد كوبون',
                'body' => 'نص اشعار جديد كوبون',
            ], [
                'lang' => 'en',
                'type' => 'Coupon',
                'title' => 'title new notification Coupon',
                'body' => 'body new notification Coupon',

            ],
        ];
        foreach ($data as $get) {
            NotificationSetting::updateOrCreate($get);
        }
    }
}
