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

    public function getTotalAttribute()
    {
        return $this->items->sum('total_amount');
    }

    public function getPercentAttribute()
    {
        return $this->items->sum('total_amount') * $this->user->tax_percent / 100;
    }

    public function getDiscountAttribute()
    {
        return $this->percent + $this->total;
    }
}
