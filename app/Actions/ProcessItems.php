<?php

namespace App\Actions;

class ProcessItems extends BaseAction
{
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
