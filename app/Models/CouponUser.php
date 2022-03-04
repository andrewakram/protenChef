<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'coupon_id',
        'used',

    ];

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function Coupon(){
        return $this->belongsTo(Coupon::class,'coupon_id');
    }
}
