<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $appends = ['title'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


    public function getTitleAttribute()
    {
        if ($locale = \app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/Package') . '/' . $image;
        }
        return asset('uploads/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'Package');
            $this->attributes['file'] = $imageFields;
        }

    }
}
