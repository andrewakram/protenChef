<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealImage extends Model
{
    use HasFactory;

    protected $fillable = ['image','meal_id'];


    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/MealImage') . '/' . $image;
        }
        return asset('default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
//            $imageFields = upload($image, 'Slider');
//            $this->attributes['image'] = $imageFields;
            $img_name = time().uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/MealImage/'),$img_name);
            $this->attributes['image'] = $img_name ;
        }

    }

    public function Meal(){
        return $this->belongsTo(Meal::class,'meal_id');
    }
}
