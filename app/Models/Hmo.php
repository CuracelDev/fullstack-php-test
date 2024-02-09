<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Hmo extends Model
{
    use HasFactory;
    use Notifiable;

    public const BATCH_PREFERENCE_ENCOUNTER_DATE = 'encounter_date';
    public const BATCH_PREFERENCE_CREATED_DATE = 'created_at';

    protected $fillable = [
        'email',
        'code',
        'name',
        'batch_preference',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(HmoBatch::class);
    }
}
