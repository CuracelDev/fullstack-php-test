<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id', 'hmo_id', 'batch_id', 'status', 'items', 'encounter_date', 'sent_date'];

    protected $dates = ['encounter_date', 'sent_date'];

    protected $casts = [
        'items' => 'json',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function hmo()
    {
        return $this->belongsTo(HMO::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
