<?php

namespace App\Models\Constants;

class HmoBatchType
{
    public const ENCOUNTER_MONTH = 'encounter_month';
    public const CREATION_MONTH = 'creation_month';

    public static function values(): array
    {
        return [static::ENCOUNTER_MONTH, static::CREATION_MONTH];
    }
}
