<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    /**
     * The "booting" method of the model, This helps to magically create uuid for all new models
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    /**
     * Get the value indicating whether or not the IDS are incrementing
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the primary key for the model
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * Get the auto-incrementing key type
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}