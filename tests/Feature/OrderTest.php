<?php

namespace Tests\Feature;

use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use App\Notifications\CreateNewOrderNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    protected $headers = [
        'accept' => 'Application/Json'
    ];

    /**
     * @test
     * @dataProvider validOrderCreationData
     */
    public function test_order_can_be_created_via_request($input): void
    {
        Notification::fake();

        $provider = Provider::factory()->create();
        $hmo = Hmo::factory()->create();

        $input['hmo_code'] = $hmo->code;
        $input['provider_code'] = $provider->code;

        $response = $this->withHeaders($this->headers)
            ->post('api/create-order', $input);

        $response->assertOk();

        $response->json([
            'status' => true,
            'message' => "Order Created"
        ]);
        $responseData = $response->json();
        $this->assertDatabaseHas(Order::class, [
            'id' => $responseData['data']['id'],
            'status' => 'pending'
        ]);

        Notification::assertSentTo($hmo, CreateNewOrderNotification::class);
    }

    /**
     * @test
     * @dataProvider invalidOrderCreationData
     */
    public function test_order_validations_works_effectively($input, $validationMessages): void
    {

        $response = $this->withHeaders($this->headers)
            ->post('api/create-order', $input);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($validationMessages);
    }


    public static function validOrderCreationData(): array
    {
        return [
            [
                [
                    'hmo_code' => null,
                    'provider_code' => null,
                    'encounter_date' => now()->format('d-m-Y'),
                    'sent_date' => now()->format('d-m-Y'),
                    'items' => [
                        [
                            'name' => 'Item Sample',
                            'quantity' => 4,
                            'unit_price' => 545,
                        ]
                    ]
                ]
            ],
            [
                [
                    'hmo_code' => null,
                    'provider_code' => null,
                    'encounter_date' => now()->format('d-m-Y'),
                    'sent_date' => now()->format('d-m-Y'),
                    'items' => [
                        [
                            'name' => 'Item Sample',
                            'quantity' => 4,
                            'unit_price' => 545,
                        ],
                        [
                            'name' => 'Item Sample11',
                            'quantity' => 65,
                            'unit_price' => 433,
                        ],
                        [
                            'name' => 'Item Sample3',
                            'quantity' => 7,
                            'unit_price' => 4444,
                        ]
                    ]
                ]
            ]

        ];
    }

    public static function invalidOrderCreationData(): array
    {
        return [
            [
                [
                    'encounter_date' => now()->format('d-m-Y'),
                    'sent_date' => now()->format('d-m-Y'),
                    'items' => [
                        [
                            'name' => 'Item Sample',
                            'quantity' => 4,
                            'unit_price' => 545,
                        ],
                    ]
                ],
                [
                    "hmo_code" => [
                        "The hmo code field is required."
                    ],
                    "provider_code" => [
                        "The provider code field is required."
                    ],
                ]
            ],
            // with wrong codes
            [
                [
                    'hmo_code' => 13,
                    'provider_code' => 'ddf-43',
                    'encounter_date' => now()->format('d-m-Y'),
                    'sent_date' => now()->format('d-m-Y'),
                    'items' => [
                        [
                            'name' => 'Item Sample',
                            'quantity' => 4,
                            'unit_price' => 545,
                        ],
                    ]
                ],
                [
                    "hmo_code" => [
                        "The selected hmo code is invalid."
                    ],
                    "provider_code" => [
                        "The selected provider code is invalid."
                    ],
                ]
            ],
            // with not items
            [
                [
                    'hmo_code' => 'HMO-A',
                    'provider_code' => 'ddf-43',
                    'encounter_date' => now()->format('d-m-Y'),
                    'sent_date' => now()->format('d-m-Y'),
                    'items' => [

                    ]
                ],
                [
                    "items" => [
                        "The items field is required."
                    ],
                ]
            ]
        ];
    }
}
