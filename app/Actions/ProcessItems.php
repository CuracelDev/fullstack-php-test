<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class ProcessItems
{
    use AsAction;

    public function handle(array $items): array
    {
       $total = 0;

       foreach ($items as &$item) {
            $item['sub_total'] = $item['unit_price'] * $item['quantity'];

            $total += $item['sub_total'];
       }

       return ['items' => $items, 'total' => $total];
    }
}
