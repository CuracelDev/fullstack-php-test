<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';

    public static function getValues(): array
    {
        return array_column(OrderStatus::cases(), 'value');
    }
}
