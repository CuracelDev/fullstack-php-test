<?php

namespace Database\Seeders;

use App\Models\Hmo;
use App\Models\Provider;
use App\Models\Order;
use Illuminate\Database\Seeder;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A'],
        ['name'=>'HMO B', 'code'=> 'HMO-B'],
        ['name'=>'HMO C', 'code'=> 'HMO-C'],
        ['name'=>'HMO D', 'code'=> 'HMO-D'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hmo::factory()->count(5)->ordersByEncounterDate()->create();
        Hmo::factory()->count(5)->ordersByDateCreated()->create();

        Provider::factory()->count(3)->create();

        Order::factory()->count(3)->create();

    }
}
