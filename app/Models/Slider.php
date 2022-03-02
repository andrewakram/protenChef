<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/Slider') . '/' . $image;
        }
        return asset('uploads/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'Slider');
            $this->attributes['file'] = $imageFields;
        }

    }
}
