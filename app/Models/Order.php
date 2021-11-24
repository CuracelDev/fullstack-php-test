<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $casts = [
        'encounter_date' => 'datetime',
        'items' => 'array',
        'processed' => 'boolean',
    ];

    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
