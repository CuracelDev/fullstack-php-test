<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'batch_criteria' => 'sent_date', 'email'=> 'info@hmoa.com'],
        ['name'=>'HMO B', 'code'=> 'HMO-B', 'batch_criteria' => 'encounter_date', 'email'=> 'info@hmob.com'],
        ['name'=>'HMO C', 'code'=> 'HMO-C', 'batch_criteria' => 'encounter_date', 'email'=> 'info@hmoc.com'],
        ['name'=>'HMO D', 'code'=> 'HMO-D', 'batch_criteria' => 'encounter_date', 'email'=> 'info@hmod.com'],
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
