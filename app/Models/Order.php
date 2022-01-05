<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'hmo_id',
        'provider_id',
        'encounter_date',
        'items'
    ];


    protected $casts = [
        'encounter_date' => 'datetime',
        'items' => 'array',
    ];

    /**
     * This get the list of belongsTo for HMO
     * 
     * @return BelongsTo
     */
    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }


    /**
     * This get the list of belongsTo for Providers
     * 
     * @return BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
