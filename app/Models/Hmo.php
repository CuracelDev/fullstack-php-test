<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Hmo extends Model
{
    use SoftDeletes,Notifiable;

    protected $fillable = [
        'name',
        'code',
        'batching_rule'
    ];

}
