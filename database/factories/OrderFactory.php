<?php

namespace Database\Factories;

use App\Models\Hmo;
use App\Services\BatchService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $hmo = Hmo::first() ?? Hmo::factory()->create();
        $items =  [
            ['item' => $this->faker->text(5), 'unit_price' => mt_rand(50,1000), 'quantity' => mt_rand(1,5)],
            ['item' => $this->faker->text(5), 'unit_price' => mt_rand(50,1000), 'quantity' => mt_rand(1,5)],
        ];
        return [
            'hmo_id' => $hmo->id,
            'reference' => generateReference(),
            'encounter_date' => Carbon::now()->subMonth()->startOfMonth()->toDateString(),
            'provider_name' => $this->faker->company,
            'items' =>$items,
            'total_amount' => collect(app(OrderService::class)->prepareOrderItems($items))->sum('total_price')
        ];
    }
}
