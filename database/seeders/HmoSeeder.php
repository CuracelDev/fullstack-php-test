<?php

namespace Database\Seeders;

use App\Constants\FulfilmentType;
use App\Models\Hmo;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
            ->count(4)
            ->state(new Sequence(
                ['fulfil_by' => FulfilmentType::ENCOUNTER],
                ['fulfil_by' => FulfilmentType::ORDER],
            ))
            ->sequence(
                ['name'=>'HMO A', 'code'=> 'HMO-A'],
                ['name'=>'HMO B', 'code'=> 'HMO-B'],
                ['name'=>'HMO C', 'code'=> 'HMO-C'],
                ['name'=>'HMO D', 'code'=> 'HMO-D'],
            )->create();
    }
}
