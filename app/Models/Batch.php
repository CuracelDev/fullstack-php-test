<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'hmo_id',
    ];

    /**
     * 
     * The orders in this batch
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
