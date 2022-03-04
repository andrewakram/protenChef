<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $appends = ['body'];

    public function getBodyAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->body_ar;
        } else {
            return $this->body_en;
        }
    }
}
