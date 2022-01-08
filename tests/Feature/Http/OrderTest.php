<?php

namespace Tests\Feature\Http;

use App\Models\Hmo;
use Tests\TestCase;
use App\Models\Batch;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_load_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_page_is_load()
    {
        $response = $this->get('/');

        $response->assertSee('Submit')->assertSuccessful();
    }

    /**
     * Batch can be seen from the endpoint
     * 
     * @return void
     */
    public function testSeeBatch()
    {

        $batch = Batch::factory()
            ->count(5)->sequence(
                [
                    'hmo_id' => '1',
                    'encounter_date' => '2022-01-05',
                    'order_ids' => json_encode(['4', '3', '2'])
                ],
                [
                    'hmo_id' => '2',
                    'encounter_date' => '2022-01-06',
                    'order_ids' => json_encode(['4', '3', '2'])
                ],
                [
                    'hmo_id' => '3',
                    'encounter_date' => '2022-01-07',
                    'order_ids' => json_encode(['4', '3', '2'])
                ],
                [
                    'hmo_id' => '4',
                    'encounter_date' => '2022-01-08',
                    'order_ids' => json_encode(['4', '3', '2'])
                ],
            )->create();

        $this->get(route('batch.index', $batch[0]['hmo_id']))
            ->assertStatus(200);
    }

    /**
     * Batch can be seen from the endpoint in asc order
     * 
     * @return void
     */
    public function testCreateOrder()
    {
        $orderPayload = [
            'hmoCode' => 'SXT-JT',
            'provider' => 'Willie Hartmann',
            'orderItems' =>
            array(
                0 =>
                array(
                    'item' => 'item1',
                    'uPrice' => '20',
                    'qty' => '30',
                    'totalPrice' => 0,
                    'subTotal' => 600,
                ),
            ),
            'totalPrice' => 600,
            'encounterDate' => '2022-01-07',
        ];
        $this->post(route('order.store'), $orderPayload)
            ->assertStatus(201);
    }

    /**
     * Endpoint to get all Orders
     * 
     * @return void
     */
    public function testCanGetAllOrders()
    {
        $order = Order::factory()->create();

        $this->get(route('order.index'))
            ->assertStatus(200);
    }

    /**
     * Make batch by encounter date 
     * 
     * @return void
     */
    public function testMakeBatchByEncounterDate()
    {
        $hmo = Hmo::factory()->sequence(
            [

                'name' => 'James',
                'code' => 'ABC-' . rand(10, 99),
                'email' => 'James@test.com',
                'batch_pref' => 'encounter_date'
            ]
        )->create();
        $this->get(route('batch.encounter-date', [$hmo->id, '02']))
            ->assertStatus(200);
    }

    /**
     * Make batch by sent date 
     * 
     * @return void
     */
    public function testMakeBatchBySentDate()
    {
        $hmo = Hmo::factory()->sequence(
            [
                'name' => 'James',
                'code' => 'CBA-' . rand(10, 99),
                'email' => 'James@test.com',
                'batch_pref' => 'date_created'
            ]
        )->create();

        $this->get(route('batch.send-date', [$hmo->id, '01']))
            ->assertStatus(200);
    }

    /**
     * Order validation checks
     * 
     * @return void
     */
    public function testValidationForOrders()
    {
        $orderPayload = [];
        $this->post(route('order.store'), $orderPayload)
            ->assertStatus(302);
    }

    /**
     * Check validation by rules created
     * 
     * @param array $orderPayload 
     * @param array $validationErrors 
     * 
     * @dataProvider orderValidationDataProvider
     * 
     * @return void
     */
    public function testOrdersAreValidated(array $orderPayload, array $validationErrors)
    {
        $this->withHeaders(
            [
                'Accept' => 'application/json',
            ]
        )->json('POST', route('order.store'), $orderPayload)
            ->assertStatus(422)
            ->assertJson($validationErrors);
    }

    /**
     * Data provider for test_orders_are_validated
     * 
     * @return array
     */
    public function orderValidationDataProvider()
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
                            'qty' => 2,
                            'uPrice' => 3,
                            'subTotal' => 10,
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
