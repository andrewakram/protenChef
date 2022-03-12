<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddition extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function mealType(){
        return $this->belongsTo(MealType::class,'meal_type_id');
    }
 }
