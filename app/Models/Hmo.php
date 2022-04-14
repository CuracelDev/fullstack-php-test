<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Hmo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const BATCH_BY_MONTH = 1;
    public const BATCH_BY_DAY = 2;


    public function scopeByCode(Builder $query, $code)
    {
        return $query->where('code', $code);
    }
}
