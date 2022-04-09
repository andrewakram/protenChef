<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_num',
        'user_id',
        'package_id',
        'package_name_ar',
        'package_name_en',
        'package_type_id',
        'package_type_ar',
        'package_type_en',
        'lat',
        'lng',
        'location_body',
        'start_date',
        'package_price',
        'shipping_price',
        'discount_price',
        'total_price',
        'status',
        'cancel_price',
        'cancel_date',
    ];

    public function OrderMeals()
    {
        return $this->hasMany(OrderMeal::class, 'order_id');
    }

    public function OrderDays()
    {
        return $this->hasMany(OrderMeal::class, 'order_id');
    }

    public function DeliveredOrderMeals()
    {
        return $this->hasMany(OrderMeal::class, 'order_id')->where('status', 'delivered');
    }
    public function OrderAdditions()
    {
        return $this->hasMany(OrderAddition::class, 'order_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
