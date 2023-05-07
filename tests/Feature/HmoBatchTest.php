<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class HmoBatchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setup();

        Artisan::call('migrate');
    }

    public function test_data_is_created_when_request_is_made(): void
    {
        $response = $this->post("/hmos/batch-data", $this->someRequestData());

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has(1)
                ->first(fn ($json) =>
                    $json->where('group_name', 'Reliance Hmo Mar 2023')
                        ->where('total_price', (3740 * 2) + (2210 * 2) + (1950 * 5))
                        ->where('order_count', 1)
                        ->where('order_items_count', 3)
                )
        );
    }

    public function test_data_is_created_for_multiple_requests(): void
    {
        $this->post("/hmos/batch-data", $this->someRequestData());
        $response = $this->post("/hmos/batch-data", $this->someRequestData('02'));

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has(2)
                ->has('0', fn ($json) =>
                    $json->where('group_name', 'Reliance Hmo Feb 2023')
                        ->where('total_price', (3740 * 2) + (2210 * 2) + (1950 * 5))
                        ->where('order_count', 1)
                        ->where('order_items_count', 3)
                )
                ->has('1', fn ($json) =>
                    $json->where('group_name', 'Reliance Hmo Mar 2023')
                        ->where('total_price', (3740 * 2) + (2210 * 2) + (1950 * 5))
                        ->where('order_count', 1)
                        ->where('order_items_count', 3)
                )
        );
    }

    protected function someRequestData($month = null): array
    {
        return [
            "code" => "1234",
            "name" => "Reliance Hmo",
            "encounter_date" => $month ? "2023-$month-03" : "2023-03-03",
            "items" => [
                [
                    "title" => "Item 1",
                    "unit_price" => "3740",
                    "quantity" => "2"
                ],[
                    "title" => "Item 2",
                    "unit_price" => "2210",
                    "quantity" => "2"
                ],[
                    "title" => "Item 3",
                    "unit_price" => "1950",
                    "quantity" => "5"
                ]
            ]
        ];
    }

}