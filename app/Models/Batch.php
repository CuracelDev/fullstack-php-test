<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Batch extends Model
{
    protected $guarged = ['id'];
    
    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
