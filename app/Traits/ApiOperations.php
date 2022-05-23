<?php


namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

trait ApiOperations
{

    public function getBatchNameByEncounterDate($provider)
    {
        return $provider->name .' ' .  Carbon::parse(now())
            ->format('M Y');   
    }

    public function getBatchNameByRequestDate($provider)
    {
        return $provider->name .' ' . Carbon::parse(now())
            ->format('M Y');
    }

}
