<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Http\Requests\CreateOrderRequest;
use App\Enums\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;

class CreateOrderRequestTest extends TestCase
{
    use RefreshDatabase;

    public function it_passes_with_valid_data()
    {
        $data = [
            'provider_id' => 1,
            'hmo_id' => 1,
            'batch_id' => 1,
            'status' => OrderStatus::PENDING->value,
            'items' => [
                [
                    'name' => 'Item 1',
                    'price' => 10.0,
                    'quantity' => 1,
                ],
            ],
            'encounter_date' => '2023-03-11',
            'sent_date' => '2023-03-11',
        ];

        $request = new CreateOrderRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_with_missing_required_fields()
    {
        $data = [];

        $request = new CreateOrderRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has(['provider_code', 'hmo_code', 'items', 'encounter_date', 'sent_date']));
    }
}
