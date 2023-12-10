<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($provider) {
            $provider->slug = Str::slug($provider->name);
        });

        static::updating(function ($provider) {
            $provider->slug = Str::slug($provider->name);
        });
    }

}
