<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'email' => 'bulaba@agbado.com', 'batch_by' => 'submit_date'],
        ['name'=>'HMO B', 'code'=> 'HMO-B', 'email' => 'chaliman.co@gmai.com', 'batch_by' => 'encounter_date'],
        ['name'=>'HMO C', 'code'=> 'HMO-C', 'email' => 'pdapc@balablue.org', 'batch_by' => 'encounter_date'],
        ['name'=>'HMO D', 'code'=> 'HMO-D', 'email' => 'votewisely@betternaija.com', 'batch_by' => 'encounter_date'],
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
