<?php

namespace Database\Seeders;

use App\Models\Hmo;
use Illuminate\Database\Seeder;

class HmoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hmo::factory()
            ->count(1)
            ->batchOrdersByDateCreated()
            ->create();

        Hmo::factory()
            ->count(1)
            ->batchOrdersByEncounterDate()
            ->create();
    }
}
