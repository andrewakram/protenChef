<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;
    protected $table = 'notification_settings';

    //'lang',['ar','en']
    //'type',['other','Order','Meal','Offer','Coupon']
    //status >> '1=>order, 2=>order_status, 3=>meal_status, 4=>cancel_order'

    protected $fillable = ['lang','type','title','body'];
}
