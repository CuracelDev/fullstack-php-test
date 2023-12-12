<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Provider extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'slug',
        'email'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($provider) {
            $provider->slug = Str::slug($provider->name);
            $provider->email = $provider->slug . '@gmail.com';
        });

        static::updating(function ($provider) {
            $provider->slug = Str::slug($provider->name);
        });
    }

}
