<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Hmo extends Model
{
    use Notifiable;

    protected $guarded = ['id'];
    
    const BATCH_CRITERIA_ENCOUNTER = 'encounter_date';
    const BATCH_CRITERIA_SENT = 'sent_date';
}
