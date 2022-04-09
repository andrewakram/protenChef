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
                'title_ar' => 'كوبون خصم هديه !!',
                'title_en' => 'gift discount coupon !!',
                'body_ar' => 'علشان انت عميل مميز عندنا كسبت كوبون خصم بقيمة 50 5 من قيمة الاشترام بحد اقصي 30 ريال سعودي',
                'body_en' => 'Because you are a special customer with us, you have earned a discount coupon of 50 5 from the value of the purchase, with a maximum of 30 Saudi riyals',
                'model_id' => $coupon->id,
                'model_type' => 'Coupon',
                'user_id' => $user->id,

            ],
            [
                'title_ar' => 'عرض جديد متاح الان',
                'title_en' => 'New offer available now',
                'body_ar' => 'انه العرض الاول الفريد من نوعه ...',
                'body_en' => 'It is a unique first...',
                'model_id' => $offer->id,
                'model_type' => 'Offer',
                'user_id' => $user->id,

            ],
            [
                'title_ar' => 'وجبه جديدة تم اضافتها',
                'title_en' => 'A new meal has been added',
                'body_ar' => 'الان تستطيع الاستمتاع بالوجبة الجديده من بروتين شيف ...',
                'body_en' => 'Now you can enjoy the new meal from Protein Chef...',
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
