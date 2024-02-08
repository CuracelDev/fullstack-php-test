<?php

namespace App\Actions\Orders;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBatchID
{
    use AsAction;

    private const FORMAT = ':provider: :month: :year:';

    public function handle(string $provider, Carbon $date): string
    {
        return Str::replace(
            explode(' ', static::FORMAT),
            [$provider, $date->shortMonthName, $date->year],
            static::FORMAT
        );
    }
}
