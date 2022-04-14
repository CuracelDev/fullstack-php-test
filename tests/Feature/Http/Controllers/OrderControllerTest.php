<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\OrderStored;
use App\Models\Hmo;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function it_can_create_orders_for_hmo(): void
    {
        Event::fake();

        $hmo = Hmo::factory()->create([
            'batch_by' => Hmo::BATCH_BY_MONTH,
        ]);

         $this->postJson('/api/orders', [
             'provider' => $this->faker->company,
             'hmo_code' => $hmo->code,
             'orders' => [
                 [
                     'item' => $this->faker->word,
                     'unit' => 1,
                     'subtotal' => 20
                 ]
             ],
             'total' => 20,
             'encounter_date' => '2021-05-04'
         ])
             ->assertCreated()
             ->assertJsonStructure([
                 'success',
                 'data' => [
                     'id',
                     'total',
                     'hmo',
                     'encounter_date',
                     'items' => [
                         '*' => [
                             'item',
                             'unit',
                             'subtotal'
                         ]
                     ],
                     'batch',
                 ],
             ]);

         Event::assertDispatched(OrderStored::class);
    }
}
