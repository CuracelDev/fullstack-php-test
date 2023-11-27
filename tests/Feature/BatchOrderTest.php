<?php

namespace Tests\Feature;

use App\Events\OrderCreated;
use App\Models\Hmo;
use App\Notifications\OrderCreated as NotificationsOrderCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class BatchOrderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
    }

    /**
     * Check for input validation
     *
     * @test
     * @return void
     */
    public function it_validates_user_input()
    {
        $data = [];
        $response = $this->post('/api/orders', $data);

        $response->assertStatus(422);
        $response->assertJson(
            ["provider_name" => [
                "The provider name field is required."
            ],
            "hmo_code" => [
                "The hmo code field is required."
            ],
            "encounter_date" => [
                "The encounter date field is required."
            ],
            "items" => [
                "The items field is required."
            ]
            ]
        );

        //encounter date must be correct date
        $data = $this->getOrderData('2023-01-10');
        $data['encounter_date'] = "sometext";
        $response = $this->post('/api/orders', $data);
        $response->assertJson(
            ["encounter_date" => [
                "The encounter date is not a valid date."
            ]]
        );

        //items elemets must be correct
        $data = $this->getOrderData('2023-01-10');
        $data['items'][0]['name'] = null;
        $data['items'][0]['unit_price'] = 'A';
        $data['items'][0]['quantity'] = 'B';
        $response = $this->post('/api/orders', $data);
        $response->assertJson(
            ["items.0.unit_price" => [
                "The items.0.unit_price must be a number."
            ],
            "items.0.quantity" => [
                "The items.0.quantity must be an integer."
            ],
            "items.0.name" => [
                "The items.0.name field is required."
            ]]
        );

        $response->assertStatus(422);
        
    }


    /**
     * Check if Order can be created successfully
     *
     * @test
     * @return void
     */
    public function it_creates_order_successfully()
    {
        $data = $this->getOrderData('2023-01-10');
        $response = $this->post('/api/orders', $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Order was created successfully']);
        $this->assertTrue(count($response->json()['data']['items']) === 2);
    }

    /**
     * Check if Order is batched according to Hmo requirements
     *
     * @test
     * @return void
     */
    public function it_batches_order_correctly()
    {
        //for the ones that require sent date
        $data = $this->getOrderData('2023-01-10');
        $response = $this->post('/api/orders', $data);

        $response->assertStatus(200);
        $this->assertEquals(
            $response->json()['data']['batch'], 
            $data['provider_name'].' '.date('M Y', strtotime(now()))
        );


        //for the ones that require encounter date
        $data = $this->getOrderData('2023-01-10', 'HMO-B');
        $response = $this->post('/api/orders', $data);

        $response->assertStatus(200);
        $this->assertEquals(
            $response->json()['data']['batch'], 
            $data['provider_name'].' '.date('M Y', strtotime($data['encounter_date']))
        );
    }

    /**
     * @test
     */
    public function it_dispatches_order_created_event()
    {
        Notification::fake();

        Event::fake([
            OrderCreated::class,
        ]);

        $data = $this->getOrderData('2023-01-10');
        $response = $this->post('/api/orders', $data);

        $response->assertStatus(200);

        Event::assertDispatched(OrderCreated::class, 1);
    }

     /**
     * @test
     */
    public function it_sends_notifications()
    {
        Notification::fake();

        $data = $this->getOrderData('2023-01-10');
        $response = $this->post('/api/orders', $data);

        $response->assertStatus(200);

        Notification::assertSentTo(
            Hmo::where('code', $data['hmo_code'])->first(), 
            NotificationsOrderCreated::class
        );
    }


    protected function getOrderData(
        string $encounterDate, 
        string $hmoCode = 'HMO-A', 
        $providerName = 'James and co', 
        $itemsCount=2
    ) : array
    {
        $data = [
            'encounter_date' => $encounterDate,
            'hmo_code' => $hmoCode,
            'provider_name' => $providerName,
            'items' => []
        ];

        for($i = 0; $i < $itemsCount; $i++) {
            $data['items'][] = [
                'name' => $this->faker->sentence(),
                'unit_price' => random_int(1000, 10000),
                'quantity' => random_int(1, 100)
            ];
        }

        return $data;
    }
}
