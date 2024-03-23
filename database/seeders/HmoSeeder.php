<?php

namespace Database\Seeders;

use App\Services\BatchService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
        $batchingRules = BatchService::getBatchingRules();

        foreach ($this->hmos as &$hmo) {
            $randomIndex = array_rand($batchingRules);
            $randomRule = $batchingRules[$randomIndex];
            $hmo['batching_rule'] = $randomRule;
        }


        DB::table('hmos')->insert($this->hmos);
    }
}
