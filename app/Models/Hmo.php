<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hmo extends Model
{
    protected $fillable = [
        'name',
        'code',
        'email',
        'batch_type',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'hmo_id');
    }
}
