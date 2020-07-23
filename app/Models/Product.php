<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'details', 'coupon_needed', 'age_limit', 'purchase_limit'
    ];x

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
