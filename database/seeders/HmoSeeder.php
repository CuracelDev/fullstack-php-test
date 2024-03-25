<?php

namespace Database\Seeders;

use App\Services\BatchService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'email' => 'hello@hmoa.com'],
        ['name'=>'HMO B', 'code'=> 'HMO-B',  'email' => 'hello@hmob.com'],
        ['name'=>'HMO C', 'code'=> 'HMO-C',  'email' => 'hello@hmoc.com'],
        ['name'=>'HMO D', 'code'=> 'HMO-D',  'email' => 'hello@hmod.com'],
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
