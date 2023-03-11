<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id', 'hmo_id', 'month', 'criteria', 'batch_by'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function hmo()
    {
        return $this->belongsTo(HMO::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
