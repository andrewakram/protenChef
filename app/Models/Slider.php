<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable=['title','url','active','image'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/Slider') . '/' . $image;
        }
        return asset('default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
//            $imageFields = upload($image, 'Slider');
//            $this->attributes['image'] = $imageFields;
            $img_name = time().uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/Slider/'),$img_name);
            $this->attributes['image'] = $img_name ;
        }else{
            $this->attributes['image'] = $image ;
        }

    }
}
