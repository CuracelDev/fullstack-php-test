<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
