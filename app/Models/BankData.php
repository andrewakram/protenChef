<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankData extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'iban', 'bank_name', 'name'];

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
