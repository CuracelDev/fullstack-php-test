<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
	use SoftDeletes;

    protected $table = 'orders';
	
	protected $fillable = ['product_id', 'user_id', 'price'];

    protected $dates = ['deleted_at'];

    public function product() {
    	return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user() {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
