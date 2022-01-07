<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItems::class);
    }

    public function sumIt()
    {
        return $this->items()->sum('total_amount');
    }

    public function getTotalAttribute()
    {
        return $this->items->sum(function (CartItems $item) {
            return $item->product_price * $item->quantity;
        });
    }
}
