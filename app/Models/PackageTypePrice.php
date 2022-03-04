<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTypePrice extends Model
{
    use HasFactory;

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
}
