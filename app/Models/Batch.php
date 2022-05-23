<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Batch extends Model
{
    protected $fillable = ['id', 'provider_id', 'orders', 'month', 'name'];

    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
