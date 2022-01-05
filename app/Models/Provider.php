<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The hmos that belong to the Provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hmos()
    {
        return $this->belongsToMany(Hmo::class, 'orders')->using(Order::class);
    }
}
