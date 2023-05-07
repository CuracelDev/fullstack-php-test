<?php

namespace App\Enums;

enum BatchType: string
{
    case ENCOUNTER_DATE = 'ENCOUNTER_DATE';
    case CREATION_DATE = 'CREATION_DATE';
}
