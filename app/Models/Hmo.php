<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hmo extends Model
{   
    use HasFactory;
    
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }   

    /**
     * The providers that belong to the Hmo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'orders')->distinct();
    }
}
