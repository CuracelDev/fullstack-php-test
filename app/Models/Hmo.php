<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hmo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'email',
        'batch_pref'
    ];

    /**
     * Hmo list of orders
     * 
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The providers that belong to the Hmo
     *
     * @return BelongsToMany
     */
    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'orders')->distinct();
    }
}
