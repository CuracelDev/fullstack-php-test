<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Hmo extends Model
{
    use Notifiable;
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'batch_requirement',
        'email'
    ];
}
