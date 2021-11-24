<?php

namespace Database\Seeders;

use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hmo1 = Hmo::factory()
                    ->batchOrdersByEncounterDate()
                    ->create();

        $hmo2 = Hmo::factory()
                    ->batchOrdersByDateCreated()
                    ->create();

        $provider1 = Provider::factory()->create();
        $provider2 = Provider::factory()->create();


        Order::factory()
            ->count(3)
            ->for($hmo1)
            ->for($provider1)
            ->create();

        Order::factory()
            ->count(3)
            ->for($hmo2)
            ->for($provider2)
            ->create();

        Order::factory()
            ->count(3)
            ->for($hmo1)
            ->for($provider2)
            ->create();

        Order::factory()
            ->count(3)
            ->for($hmo2)
            ->for($provider1)
            ->create();
    }
}
