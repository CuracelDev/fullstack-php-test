<?php

namespace Tests\Feature\Provider;

use App\Mail\Provider\OrderSubmitted;
use App\Models\Hmo;
use App\Models\Order;
use Carbon\Carbon;
use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class SubmitOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(HmoSeeder::class);
    }

    public function testItSubmitsAnOrderSuccessfully()
    {
        Mail::fake();

        $orderCreationPayload = $this->getOrderCreationPayload();

        $response = $this->post('/api/orders', $orderCreationPayload);

        $response->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Order submitted successfully.',
            ]);

        $this->assertDatabaseHas('orders', [
            'provider' => $orderCreationPayload['name'],
            'status' => Order::STATUS_PENDING,
            'encounter_date' => $orderCreationPayload['encounter_date'],
            'items' => json_encode($orderCreationPayload['items']),
        ]);

        $this->assertNotNull(Order::first()->batch_id); //for this test, only ascertain that the batch id is filled

        Mail::assertQueued(OrderSubmitted::class);
    }

    public function testItBatchesASubmittedOrderByEncounterDate()
    {
        Mail::fake();

        $hmoToUse = Hmo::inRandomOrder()->first();
        $hmoToUse->update(['batch_by_encounter_date' => true]);
        $encounterDate = $this->faker->dateTimeBetween('-10 months', '-3 months')->format('Y-m-d');

        $orderCreationPayload = $this->getOrderCreationPayload(['hmo' => $hmoToUse->code, 'encounter_date' => $encounterDate]);

        $expectedBatchId = $this->generateBatchId($orderCreationPayload['name'], $encounterDate);

        $response = $this->post('/api/orders', $orderCreationPayload);

        $response->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Order submitted successfully.',
            ]);

        $this->assertDatabaseHas('orders', [
            'provider' => $orderCreationPayload['name'],
            'status' => Order::STATUS_PENDING,
            'hmo_id' => $hmoToUse->id,
            'batch_id' => $expectedBatchId,
            'encounter_date' => $orderCreationPayload['encounter_date'],
            'items' => json_encode($orderCreationPayload['items']),
        ]);

        Mail::assertQueued(OrderSubmitted::class);
    }

    public function testItBatchesASubmittedOrderByCreationDate()
    {
        Mail::fake();

        Carbon::setTestNow(now()); //freeze time in case the test runs then completes when the time period has changed.

        $hmoToUse = Hmo::inRandomOrder()->first();
        $hmoToUse->update(['batch_by_encounter_date' => false]);
        $encounterDate = $this->faker->dateTimeBetween('-10 months', '-3 months')->format('Y-m-d');

        $orderCreationPayload = $this->getOrderCreationPayload(['hmo' => $hmoToUse->code, 'encounter_date' => $encounterDate]);

        $expectedBatchId = $this->generateBatchId($orderCreationPayload['name'], now()->format('Y-m-d'));

        $response = $this->post('/api/orders', $orderCreationPayload);

        $response->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Order submitted successfully.',
            ]);

        $this->assertDatabaseHas('orders', [
            'provider' => $orderCreationPayload['name'],
            'status' => Order::STATUS_PENDING,
            'hmo_id' => $hmoToUse->id,
            'batch_id' => $expectedBatchId,
            'encounter_date' => $orderCreationPayload['encounter_date'],
            'items' => json_encode($orderCreationPayload['items']),
        ]);

        Mail::assertQueued(OrderSubmitted::class);
    }

    public function testItReturnsAnErrorWhenAnInvalidHmoIsSelected()
    {
        Mail::fake();

        $orderCreationPayload = $this->getOrderCreationPayload(['hmo' => 'invalid_hmo']);

        $response = $this->post('/api/orders', $orderCreationPayload);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'status' => false,
                'message' => 'The selected hmo is invalid.',
            ]);

        $this->assertDatabaseMissing('orders', [
            'provider' => $orderCreationPayload['name'],
            'status' => Order::STATUS_PENDING,
            'encounter_date' => $orderCreationPayload['encounter_date'],
            'items' => json_encode($orderCreationPayload['items']),
        ]);

        Mail::assertNotQueued(OrderSubmitted::class);
    }

    public function testItReturnsAnErrorWhenTheEncounterDateSelectedIsGreaterThanToday()
    {
        Mail::fake();

        Carbon::setTestNow(now());

        $orderCreationPayload = $this->getOrderCreationPayload(['encounter_date' => now()->addDays(3)->format('Y-m-d')]);

        $response = $this->post('/api/orders', $orderCreationPayload);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'status' => false,
                'message' => 'The encounter date must be a date before or equal to today.',
            ]);

        $this->assertDatabaseMissing('orders', [
            'provider' => $orderCreationPayload['name'],
            'status' => Order::STATUS_PENDING,
            'encounter_date' => $orderCreationPayload['encounter_date'],
            'items' => json_encode($orderCreationPayload['items']),
        ]);

        Mail::assertNotQueued(OrderSubmitted::class);
    }

    public function testItReturnsAnErrorWhenADuplicateItemIsPresentInTheItemsPayload()
    {
        Mail::fake();

        $orderCreationPayload = $this->getOrderCreationPayload();
        array_push($orderCreationPayload['items'], $orderCreationPayload['items'][0]);

        $response = $this->post('/api/orders', $orderCreationPayload);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'status' => false,
                'message' => 'One of the items has been entered twice. You can fix this by removing the duplicate item',
            ]);

        $this->assertDatabaseMissing('orders', [
            'provider' => $orderCreationPayload['name'],
            'status' => Order::STATUS_PENDING,
            'encounter_date' => $orderCreationPayload['encounter_date'],
            'items' => json_encode($orderCreationPayload['items']),
        ]);

        Mail::assertNotQueued(OrderSubmitted::class);
    }

    private function getOrderCreationPayload(array $substitutingPayload = []): array
    {
        return [
            'name' => Str::random(10),
            'hmo' => $substitutingPayload['hmo'] ?? Hmo::inRandomOrder()->first()->code,
            'encounter_date' => $substitutingPayload['encounter_date'] ?? $this->faker()->date(),
            'items' => [
                [
                    'item' => Str::random(10),
                    'price' => $this->faker()->randomFloat(2, 1),
                    'quantity' => $this->faker()->numberBetween(1, 20),
                ],
            ],
        ];
    }

    private function generateBatchId(string $providerName, string $dateToUse): string
    {
        $provider = strtoupper(Str::snake($providerName));

        $batchDate = Carbon::parse($dateToUse);

        $batchMonth = $batchDate->format('M');
        $batchYear = $batchDate->year;

        return "{$provider}-{$batchMonth}-{$batchYear}";
    }
}
