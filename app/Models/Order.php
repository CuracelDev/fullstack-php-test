<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'encounter_date' => 'date',
        'items' => 'array'
    ];

    protected $guarded = ['id'];

    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class, 'hmo_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    protected function items(): Attribute
    {
        return Attribute::make(
            set: fn (array $value) => json_encode($value),
        );
    }

    protected function sentDate(): Attribute
    {
        return Attribute::make(
            set: fn (string|\DateTimeInterface $value) => is_string($value) ?
                Carbon::parse($value) : $value,
        );
    }

}
