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

    protected $fillable = ['lang','type','title','body'];
}
