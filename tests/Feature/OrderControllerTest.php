<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use App\Models\Order;
use DateTime;
use Mockery;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_order()
    {
        $response = $this->post('/api/order', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "hmo_code" => ["The hmo code field is required."],
            "name" => ["The name field is required."],
            "date" => ["The date field is required."],
            "items" => ["The items field is required."],
        ]);

        $this->refreshApplication();
        $response = $this->post('/api/order', [
            "hmo_code" => 100,
            "name" => 200,
            "date" => "not a date",
            "items" => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "hmo_code" => ["The hmo code must be a string."],
            "name" => ["The name must be a string."],
            "date" => ["The date is not a valid date."],
            "items" => ["The items field is required."],
        ]);
        
        $this->refreshApplication();
        $response = $this->post('/api/order', [
            "hmo_code" => "HMO-1",
            "name" => "Provider A",
            "date" => "Jan 10 2000",
            "items" => [[]],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "items.0.name" => ["The items.0.name field is required."],
            "items.0.unit_price" => ["The items.0.unit_price field is required."],
            "items.0.quantity" => ["The items.0.quantity field is required."],
        ]);

        $this->refreshApplication();
        $response = $this->post('/api/order', [
            "hmo_code" => "HMO-1",
            "name" => "Provider A",
            "date" => "Jan 10 2000",
            "items" => [
                [
                    "name" => 100,
                    "unit_price" => "not a number",
                    "quantity" => "not a number",
                ],
                [
                    "name" => "Item 1",
                    "unit_price" => 100,
                    "quantity" => 2,
                ],
                [
                    "name" => "Item 1",
                    "unit_price" => 100,
                    "quantity" => 2,
                ]
            ],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "items.0.name" => ["The items.0.name must be a string."],
            "items.0.unit_price" => ["The items.0.unit_price must be a number."],
            "items.0.quantity" => ["The items.0.quantity must be a number."],
            "items.1.name" => ["The items.1.name field has a duplicate value."],
            "items.2.name" => ["The items.2.name field has a duplicate value."],
        ]);

        
        $this->refreshApplication();
        $dateFormat = "M d Y";
        $input = [
            "hmo_code" => "HMO-1",
            "provider_name" => "Provider A",
            "date" => new DateTime("Jan 10 2000"),
            "items" => [
                [
                    "name" => "Item 1",
                    "unit_price" => 100,
                    "quantity" => 2,
                ],
            ],
        ];

        $orderMock = Mockery::mock("alias:" . Order::class);
        $orderMock->shouldReceive("create")
            ->with(Mockery::on(function($args) use ($input) {
                return ($args == $input);
            }))->andReturn([]);
        $this->app->instance(Order::class, $orderMock);

        $response = $this->post('/api/order', [
            "hmo_code" =>  $input["hmo_code"],
            "name" => $input["provider_name"],
            "date" => $input["date"]->format($dateFormat),
            "items" => $input["items"],
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(["message" => "Order successfully created."]);
    }
}
