<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Meal;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $coupon = Coupon::first();
        $offer = Offer::first();
        $meal = Meal::first();
        $data = [
            [
                'title' => 'كوبون خصم هديه !!',
                'body' => 'علشان انت عميل مميز عندنا كسبت كوبون خصم بقيمة 50 5 من قيمة الاشترام بحد اقصي 30 ريال سعودي',
                'model_id' => $coupon->id,
                'model_type' => 'Coupon',
                'user_id' => $user->id,

            ],
            [
                'title' => 'عرض جديد متاح الان',
                'body' => 'انه العرض الاول الفريد من نوعه ...',
                'model_id' => $offer->id,
                'model_type' => 'Offer',
                'user_id' => $user->id,

            ],
            [
                'title' => 'وجبه جديدة تم اضافتها',
                'body' => 'الان تستطيع الاستمتاع بالوجبة الجديده من بروتين شيف ...',
                'model_id' => $meal->id,
                'model_type' => 'Meal',
                'user_id' => $user->id,

            ]

        ];
        foreach ($data as $get) {
            Notification::updateOrCreate($get);
        }
    }
}
