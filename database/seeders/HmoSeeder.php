<?php

namespace Database\Seeders;

use App\Models\Hmo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [ 
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'email' => 'admin@hmoa.com', 'batch_criteria' => Hmo::BATCH_CRITERIA_ORDER_DATE],
        ['name'=>'HMO B', 'code'=> 'HMO-B', 'email' => 'admin@hmob.com', 'batch_criteria' => Hmo::BATCH_CRITERIA_ENCOUNTER_DATE],
        ['name'=>'HMO C', 'code'=> 'HMO-C', 'email' => 'admin@hmoc.com', 'batch_criteria' => Hmo::BATCH_CRITERIA_ENCOUNTER_DATE],
        ['name'=>'HMO D', 'code'=> 'HMO-D', 'email' => 'admin@hmod.com', 'batch_criteria' => Hmo::BATCH_CRITERIA_ENCOUNTER_DATE]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hmos')->insert($this->hmos);
    }
}
