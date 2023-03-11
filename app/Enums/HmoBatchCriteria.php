<?php

namespace App\Enums;

enum HmoBatchCriteria: string
{
    case SUBMIT_DATE = 'submit_date';
    case ENCOUNTER_DATE = 'encounter_date';
}
