<?php

namespace Tests\Unit\Actions\Order;

use App\Actions\Order\CalculateOrderItemsTotal;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class CalculateOrderItemsTotalTest extends TestCase
{
    use WithFaker;

    public function testCalulateOrderItemsReturnsTotalItemsAmount()
    {
        $total = CalculateOrderItemsTotal::run(
            [
                ['item' => 'shirt', 'quantity' => 2, 'price' => 4000],
                ['item' => 'boots', 'quantity' => 2, 'price' => 5000],
            ]
        );

        $this->assertIsInt($total);
        $this->assertEquals(18000, $total);
    }
}
