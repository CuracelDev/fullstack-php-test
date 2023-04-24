<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name' => 'HMO A', 'email' => 'hmoa@example.com', 'code' => 'HMO-A', 'batch_by_encounter_date' => false],
        ['name' => 'HMO B', 'email' => 'hmob@example.com', 'code' => 'HMO-B', 'batch_by_encounter_date' => true],
        ['name' => 'HMO C', 'email' => 'hmoc@example.com', 'code' => 'HMO-C', 'batch_by_encounter_date' => true],
        ['name' => 'HMO D', 'email' => 'hmod@example.com', 'code' => 'HMO-D', 'batch_by_encounter_date' => true],
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
