<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealType extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar', 'title_en', 'type', 'image'];

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

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/MealType') . '/' . $image;
        }
        return asset('default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
//            $imageFields = upload($image, 'Slider');
//            $this->attributes['image'] = $imageFields;
            $img_name = time().uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/MealType/'),$img_name);
            $this->attributes['image'] = $img_name ;
        }

    }
}
