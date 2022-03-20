<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageMeal extends Model
{
    use HasFactory;

    protected $fillable = ['week','day','meal_id','package_id','meal_type_id'];

    function Package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    function MealType()
    {
        return $this->belongsTo(MealType::class, 'meal_type_id');
    }

    function Meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }
}
