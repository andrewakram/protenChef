<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTypePrice extends Model
{
    use HasFactory;

    protected $fillable = ['package_id','package_type_id','active','price'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function PackageType()
    {
        return $this->belongsTo(PackageType::class, 'package_type_id');
    }

    public function Package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function PackageAddition()
    {
        return $this->hasMany(PackageMealType::class, 'package_type_price_id')
            ->whereNotNull('price');
    }
}
