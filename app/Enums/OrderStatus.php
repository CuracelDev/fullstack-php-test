<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';

    case FAILED = 'failed';

    case PROCESSED = 'processed';
}
