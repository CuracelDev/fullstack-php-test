<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['hmo_id', 'provider_id', 'items', 'encounter_date', 'deleted_at'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
