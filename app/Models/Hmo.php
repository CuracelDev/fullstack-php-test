<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Hmo extends Model
{
    use Notifiable, HasFactory;

    protected $fillable = [
        "code", "name", "email"
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
