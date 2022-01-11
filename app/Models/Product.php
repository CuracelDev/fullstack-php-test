<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_products');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
