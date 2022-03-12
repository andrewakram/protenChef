<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMeal extends Model
{
    use HasFactory;

    protected $appends = ['meal_title', 'meal_body'];
    public function getMealTitleAttribute()
    {
        if ($locale = \app()->getLocale() == "ar") {
            return $this->meal_title_ar;
        } else {
            return $this->meal_title_en;
        }
    }

    public function getMealBodyAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->meal_body_ar;
        } else {
            return $this->meal_body_en;
        }
    }

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function Meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }
}
