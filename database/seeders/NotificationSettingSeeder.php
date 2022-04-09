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
        //'type',['other','Order','Meal','Offer','Coupon']
        //status >> '1=>order, 2=>order_status, 3=>meal_status, 4=>cancel_order'

        $data = [
            [
                'type' => 'Other',
                'title_ar' => 'عنوان اشعار جديد',
                'body_ar' => 'نص اشعار جديد',
                'title_en' => 'title new notification',
                'body_en' => 'body new notification',

            ],
            /////////////////////////////order
            [
                'type' => 'Order',
                'status' => 1,
                'title_ar' => 'عنوان اشعار جديد طلب',
                'body_ar' => 'نص اشعار جديد طلب',
                'title_en' => 'title new notification Order',
                'body_en' => 'body new notification Order',
            ],
            [
                'type' => 'Order',
                'status' => 2,
                'title_ar' => 'عنوان اشعار جديد طلب',
                'body_ar' => 'نص اشعار جديد طلب',
                'title_en' => 'title new notification Order',
                'body_en' => 'body new notification Order',
            ],
            [
                'type' => 'Order',
                'status' => 3,
                'title_ar' => 'عنوان اشعار جديد طلب',
                'body_ar' => 'نص اشعار جديد طلب',
                'title_en' => 'title new notification Order',
                'body_en' => 'body new notification Order',
            ],
            [
                'type' => 'Order',
                'status' => 4,
                'title_ar' => 'عنوان اشعار جديد طلب',
                'body_ar' => 'نص اشعار جديد طلب',
                'title_en' => 'title new notification Order',
                'body_en' => 'body new notification Order',
            ]
            //////////////////////////////////========
            ,
            [
                'type' => 'Meal',
                'title_ar' => 'عنوان اشعار جديد وجبة',
                'body_ar' => 'نص اشعار جديد وجبة',
                'title_en' => 'title new notification Meal',
                'body_en' => 'body new notification Meal',
            ],

            [
                'type' => 'Offer',
                'title_ar' => 'عنوان اشعار جديد عرض',
                'body_ar' => 'نص اشعار جديد عرض',
                'title_en' => 'title new notification Offer',
                'body_en' => 'body new notification Offer',
            ],
            [
                'type' => 'Coupon',
                'title_ar' => 'عنوان اشعار جديد كوبون',
                'body_ar' => 'نص اشعار جديد كوبون',
                'title_en' => 'title new notification Coupon',
                'body_en' => 'body new notification Coupon',
            ],
        ];
        foreach ($data as $get) {
            NotificationSetting::updateOrCreate($get);
        }
    }
}
