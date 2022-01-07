<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'hmo_id',
        'order_ids',
        'encounter_date'
    ];

    /**
     * Get the Batch that belongs to the HMO
     * 
     * @return BelongsTo
     */
    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
