<?php

namespace App\Actions\Order\ValueObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CreateOrderDto
{
    public function __construct(
       public readonly string $provider,
       public readonly int $hmoId,
       public readonly Carbon|string $encounterDate,
       public readonly array $items,
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            provider: $request->input('provider'),
            hmoId: $request->input('hmo_id'),
            encounterDate: $request->date('encounter_date'),
            items: $request->input('items')
        );
    }

    public function toArray(): array
    {
        return array_merge(...array_map(
            fn ($key) => [Str::snake($key) => $this->$key],
            array_keys(get_object_vars($this))
        ));
    }
}
