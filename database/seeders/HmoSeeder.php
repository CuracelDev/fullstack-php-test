<?php

namespace Database\Seeders;

use App\Models\Hmo;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hmos = [
            ['name'=>'HMO A', 'code'=> 'HMO-A', 'email' => 'hmo-a@domain.com', 'batch_by' => Hmo::BATCH_BY_DAY],
            ['name'=>'HMO B', 'code'=> 'HMO-B', 'email' => 'hmo-b@domain.com', 'batch_by' => Hmo::BATCH_BY_MONTH],
            ['name'=>'HMO C', 'code'=> 'HMO-C', 'email' => 'hmo-c@domain.com', 'batch_by' => Hmo::BATCH_BY_MONTH],
            ['name'=>'HMO D', 'code'=> 'HMO-D', 'email' => 'hmo-d@domain.com', 'batch_by' => Hmo::BATCH_BY_MONTH],
        ];

        DB::table('hmos')->insert($hmos);
    }
}
