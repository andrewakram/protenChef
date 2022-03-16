<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar', 'title_en', 'active', 'image', 'sum_package_income'];

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
        return asset('default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
//            $imageFields = upload($image, 'Slider');
//            $this->attributes['image'] = $imageFields;
            $img_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/Package/'), $img_name);
            $this->attributes['image'] = $img_name;
        }

    }

    public function getSumPackageIncomeAttribute()
    {
        return $this->HasMany(Order::class, 'package_id')->where('status','!=','canceled')->sum('total_price');
    }

}
