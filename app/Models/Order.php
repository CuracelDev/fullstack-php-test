<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        "hmo_id", "batch_id", "provider_name", "encounter_date", "status"
    ];

    protected $dates = [
        "encounter_date"
    ];

    protected $casts = [
        "hmo_id" => "int"
    ];

    public function hmo() {
        return $this->belongsTo(Hmo::class);
    }

    public function batch() {
        return $this->belongsTo(Batch::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
