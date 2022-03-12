<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar', 'body_ar','title_en', 'body_en','meal_type_id'];

    protected $appends = ['title', 'body'];

    public function getTitleAttribute()
    {
        if ($locale = \app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function getBodyAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->body_ar;
        } else {
            return $this->body_en;
        }
    }

    public function Image()
    {
        return $this->hasOne(MealImage::class, 'meal_id');
    }

    public function MealType()
    {
        return $this->belongsTo(MealType::class, 'meal_type_id');
    }



}
