<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
      'items', 'hmo_id', 'order_id', 'edate'
    ];

    protected $table = "batches";

    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
