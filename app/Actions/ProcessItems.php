<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class ProcessItems
{
    use AsAction;

    public function handle(array $items): array
    {
       foreach ($items as &$item) {
            $item['sub_total'] = $item['unit_price'] * $item['quantity'];
       }

       $total = array_reduce($items, function ($sum, $item) {
            $sum += $item['sub_total'];
            return $sum;
       });

       return ['items' => $items, 'total' => $total];
    }
}
