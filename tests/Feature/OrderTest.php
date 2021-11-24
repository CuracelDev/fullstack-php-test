<?php

namespace Tests\Feature;

use App\Models\Hmo;
use Tests\TestCase;
use App\Models\Provider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public $hmo;
    public $provider;

    protected function setUp() : void
    {
        parent::setUp();

        $this->hmo = $hmo2 = Hmo::factory()->create();
        $this->provider = Provider::factory()->create();
    }

    public function test_order_creation_page_loads()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @dataProvider validationDataProvider
     */
    public function test_orders_are_validated(array $order, array $validationErrors)
    {
        $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', 'api/orders', $order)
            ->assertStatus(422)
            ->assertJson($validationErrors);
    }

    public function test_order_can_be_created()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', 'api/orders', [
            'hmoCode' => $this->hmo->code,
            'provider' => $this->provider->name,
            'totalPrice' => 12,
            'encounterDate' => '2018-01-01',
            'orderItems' => [
                [
                    'item' => 'item 1',
                    'quantity' => 2,
                    'unitPrice' => 3,
                    'totalPrice' => 6,
                ],
                [
                    'item' => 'item N',
                    'quantity' => 2,
                    'unitPrice' => 3,
                    'totalPrice' => 6,
                ],
            ],
        ])->assertStatus(201);
        
        $this->assertDatabaseHas('orders', [
            'hmo_id' => $this->hmo->id,
            'provider_id' => $this->provider->id,
            'processed' => false
        ]);
    }


    /**
     * Data provider for test_orders_are_validated
     */
    public function validationDataProvider()
    {
        return [
            'empty data' => [
                [],
                [
                    "message" => "The given data was invalid.",
                    "errors" => [
                        "hmoCode" => ["The hmo code field is required."],
                    ]
                ]
            ],
            'hmo does not exist' => [
                ['hmoCode' => 'no hmo should have this code'],
                [
                    "message" => "The given data was invalid.",
                    "errors" => [
                        "hmoCode" => ["The selected hmo code is invalid."],
                    ]
                ]
            ],
            'encounter date is a date' => [
                ['encounterDate' => 'not a date'],
                [
                    "message" => "The given data was invalid.",
                    "errors" => [
                        "encounterDate" => ["The encounter date is not a valid date."],
                    ]
                ]
            ],
            'total price is not valid' => [
                [
                    'totalPrice' => 200,
                    'orderItems' => [
                        [
                            'item' => 'item N',
                            'quantity' => 2,
                            'unitPrice' => 3,
                            'totalPrice' => 10,
                        ]
                    ]
                ],
                [
                    "message" => "The given data was invalid.",
                    "errors" => [
                        'totalPrice' => ["The total price is invalid"],
                    ]
                ]
            ],
        ];
    }

    
}
