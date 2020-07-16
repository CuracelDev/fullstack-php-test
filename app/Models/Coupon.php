<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
	use SoftDeletes;

    protected $table = 'coupons';
	
	protected $fillable = [ 'code', 'tax'];

    protected $dates = ['deleted_at'];
}
