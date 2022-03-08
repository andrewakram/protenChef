<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealImage extends Model
{
    use HasFactory;

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/Meal') . '/' . $image;
        }
        return asset('uploads/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'Meal');
            $this->attributes['file'] = $imageFields;
        }

    }
}
