<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function OrderMeals()
    {
        return $this->hasMany(OrderMeal::class, 'order_id');
    }

    public function DeliveredOrderMeals()
    {
        return $this->hasMany(OrderMeal::class, 'order_id')->where('status', 'delivered');
    }


}
