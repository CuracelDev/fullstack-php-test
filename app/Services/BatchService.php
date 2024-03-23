<?php

namespace App\Services;

class BatchService
{
    public static function getBatchingRules(): array
    {
        return ['encounter_Month', 'month_filed'];
    }
}
