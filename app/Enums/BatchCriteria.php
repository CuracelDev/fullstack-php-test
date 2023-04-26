<?php

namespace App\Enums;

enum BatchCriteria: string
{
    case SUBMISSION_DATE = 'submission_date';
    case ENCOUNTER_DATE = 'encounter_date';

    public static function getValues(): array
    {
        return array_column(BatchCriteria::cases(), 'value');
    }
}
