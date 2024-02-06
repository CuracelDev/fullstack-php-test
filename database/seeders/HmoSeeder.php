<?php

namespace Database\Seeders;

use App\Models\Constants\HmoBatchType;
use App\Models\Hmo;
use Illuminate\Database\Seeder;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name' => 'HMO A', 'code' => 'HMO-A'],
        ['name' => 'HMO B', 'code' => 'HMO-B'],
        ['name' => 'HMO C', 'code' => 'HMO-C'],
        ['name' => 'HMO D', 'code' => 'HMO-D'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hmo::factory()
            ->sequence(
                ...collect(HmoBatchType::values())
                    ->map(function (string $batchType) {
                        return ['batch_type' => $batchType];
                    })
            )
            ->createMany($this->hmos);
    }
}
