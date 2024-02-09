<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HmoBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'hmo_id',
        'name',
        'cancelled_at',
        'finished_at',
    ];

    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
