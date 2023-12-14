<?php

namespace Tests\Unit;

use App\Actions\ProcessItems;
use PHPUnit\Framework\TestCase;

class ProcessItemsActionTest extends TestCase
{
    /**
     * @test
     */
    public function test_that_items_processed_returns_correct_output(): void
    {
        $result = ProcessItems::run([[
            "name"  => "Apple",
            "unit_price" => 10,
            "quantity" => 3
        ],
        [
            "name"  => "Orange",
            "unit_price" => 4,
            "quantity" => 15
        ]]);

        $this->assertIsArray($result);

        $this->assertEquals([
            'items' => [
                [
                    "name"  => "Apple",
                    "unit_price" => 10,
                    "quantity" => 3,
                    "sub_total" => 30
                ],
                [
                    "name"  => "Orange",
                    "unit_price" => 4,
                    "quantity" => 15,
                    "sub_total" => 60
                ]
            ], 
            'total' => 90
        ], $result);
    }

    /**
     * @test
     */
    public function test_that_empty_items_processed_returns_correct_output(): void
    {
        $result = ProcessItems::run([]);

        $this->assertIsArray($result);

        $this->assertEquals([
            'items' => [], 
            'total' => 0
        ], $result);
    }
}
