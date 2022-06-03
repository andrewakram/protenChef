<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar','title_en','days_count','type','image','parent_id'];

    protected $appends = ['title'];


    public function getTitleAttribute()
    {
        if ($locale = \app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function SubPackages(){
        return $this->hasMany(PackageType::class,'parent_id');
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/PackageType') . '/' . $image;
        }
        return asset('default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
//            $imageFields = upload($image, 'Slider');
//            $this->attributes['image'] = $imageFields;
            $img_name = time().uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/PackageType/'),$img_name);
            $this->attributes['image'] = $img_name ;
        }else{
            $this->attributes['image'] = $image ;
        }

    }
}
