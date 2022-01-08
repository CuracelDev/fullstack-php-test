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

    // get the total amount of all cart items
    public function getTotalAttribute()
    {
        return $this->items->sum('total_amount');
    }

    // get the percentage of the tax and calculate it against tax percentage of the user
    public function getPercentAttribute()
    {
        return $this->items->sum('total_amount') * $this->user->tax_percent / 100;
    }

    // get the total amount plus tax for the user
    public function getTaxAttribute()
    {
        return $this->percent + $this->total;
    }
}
