<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Hmo extends Model
{
    use SoftDeletes,Notifiable,HasFactory;

    protected $fillable = [
        'name',
        'code',
        'batching_rule'
    ];

}
