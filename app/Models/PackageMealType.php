<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageMealType extends Model
{
    use HasFactory;

    protected $fillable = ['package_type_price_id','price','meal_type_id'];

    function MealType()
    {
        return $this->belongsTo(MealType::class, 'meal_type_id');
    }

    function PackageTypePrice()
    {
        return $this->belongsTo(PackageTypePrice::class, 'package_type_price_id');
    }
}
