<?php

namespace Tests\Feature;

use App\Events\OrderSubmitted;
use App\Models\Hmo;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SubmitOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_that_the_submission_returns_correct_response(): void
    {
        Event::fake();

        $response = $this->postJson('/api/submit-order', [
            'hmo_code' => 'HMO-D',
            'provider_name' => 'Provider B',
            'encounter_date' => '15-10-2023',
            'items'=> [
                [
                    'name' => 'Apple',
                    'unit_price' => 10,
                    'quantity' => 3
                ],
                [
                    'name' => 'Orange',
                    'unit_price' => 4,
                    'quantity' => 15
                ]
            ]
        ]);

        $response->assertStatus(200)->assertExactJson(['success' => true, 'message' => 'Order processed']);
    }

    /** @test */
    public function test_that_the_submission_triggers_an_order_submitted_event(): void
    {
        Event::fake();
    
        $this->postJson('/api/submit-order', [
            'hmo_code' => 'HMO-D',
            'provider_name' => 'Provider B',
            'encounter_date' => '15-10-2023',
            'items'=> [
                [
                    'name' => 'Apple',
                    'unit_price' => 10,
                    'quantity' => 3
                ],
                [
                    'name' => 'Orange',
                    'unit_price' => 4,
                    'quantity' => 15
                ]
            ]
        ]);
    
        Event::assertDispatched(OrderSubmitted::class);
    }

    /** @test */
    public function test_that_the_submission_got_stored_in_db(): void
    {
        Event::fake();

        $data = [
            'hmo_code' => 'HMO-D',
            'provider_name' => 'Provider B',
            'encounter_date' => '15-10-2023',
            'items'=> [
                [
                    'name' => 'Apple',
                    'unit_price' => 10,
                    'quantity' => 3
                ],
                [
                    'name' => 'Orange',
                    'unit_price' => 4,
                    'quantity' => 15
                ]
            ]
        ];

        $this->postJson('/api/submit-order', $data);

        $hmoId = Hmo::firstWhere('code', $data['hmo_code'])->id;
        $items = DB::table('orders')->where([['order_amount', 90],['hmo_id', $hmoId], ['provider_name', $data['provider_name']]])->value('items');

        $this->assertJsonStringEqualsJsonString(json_encode([
            [
                'name' => 'Apple',
                'quantity' => 3,
                'sub_total' => 30,
                'unit_price' => 10
            ],
            [
                'name' => 'Orange',
                'quantity' => 15,
                'sub_total' => 60,
                'unit_price' => 4
            ]
        ]), $items);

        $this->assertDatabaseHas('orders', [
            'provider_name' => $data['provider_name'],
            'hmo_id' => $hmoId,
            'order_amount' => 90,
            'encounter_date' => Carbon::parse($data['encounter_date'])->toDateTimeString(),
            'batch_id' => null
        ]);  
    }

        /** @test */
    public function test_that_invalid_data_is_not_submitted(): void
    {
        Event::fake();

        $response = $this->postJson('/api/submit-order', [
            'hmo_code' => 'HMO-D',
            'provider_name' => '',
            'encounter_date' => 111,
            'items'=> [
                [
                    'name' => 'Apple',
                    'unit_price' => [],
                    'quantity' => 3
                ],
                [
                    'name' => 'Orange',
                    'unit_price' => 4,
                    'quantity' => 'jfjfhf'
                ]
            ]
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['provider_name', 'encounter_date', 'items.0.unit_price', 'items.1.quantity']);
        $this->assertDatabaseMissing('orders', [
            'provider_name' => '',
            'encounter_date' => 111
        ]);
        Event::assertNotDispatched(OrderSubmitted::class);
    }
}
