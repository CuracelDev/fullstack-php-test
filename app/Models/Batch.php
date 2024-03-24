<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'identifier',
        'hmo_id',
        'status',
        'reference',
        'total_amount'
    ];


    /**
     * A batch has many orders
     */
    public function orders() : BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'batch_order')->using(BatchOrder::class);

    }

}
