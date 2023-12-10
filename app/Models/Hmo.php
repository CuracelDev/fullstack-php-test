<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hmo extends Model
{
    protected $fillable = [
        'name',
        'code',
        'batch_requirement'
    ];
}
