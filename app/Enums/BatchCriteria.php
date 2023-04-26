<?php

namespace App\Enums;

enum BatchCriteria: string
{
    case SUBMISSION_DATE = 'submit_date';
    case ENCOUNTER_DATE = 'encounter_date';
}
