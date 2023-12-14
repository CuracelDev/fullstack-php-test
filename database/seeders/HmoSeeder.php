<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'email' => 'hmo_a@mail.com', 'batch_criteria' => 'order_date'],
        ['name'=>'HMO B', 'code'=> 'HMO-B', 'email' => 'hmo_b@mail.com', 'batch_criteria' => 'encounter_date'],
        ['name'=>'HMO C', 'code'=> 'HMO-C', 'email' => 'hmo_c@mail.com', 'batch_criteria' => 'encounter_date'],
        ['name'=>'HMO D', 'code'=> 'HMO-D', 'email' => 'hmo_d@mail.com', 'batch_criteria' => 'encounter_date'],
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
