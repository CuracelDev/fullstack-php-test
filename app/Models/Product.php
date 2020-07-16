<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

    protected $table = 'products';
	
	protected $fillable = [
    	'name',
    	'price',
    	'pix',
    	'age_limit_status',
    	'start_age_range',
    	'end_age_range',
    	'coupon_status',
    	'coupon_id',
    	'frequency_limit_status',
    	'frequency_limit'
    ];

    protected $dates = ['deleted_at'];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
