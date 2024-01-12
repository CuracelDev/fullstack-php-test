<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        [
            'name' => 'HMO A',
            'slug' => 'hmo-a',
            'email' => 'hmo_a@example.com',
            'code' => 'HMO-A',
            'batch_by_encounter_date' => true,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO B',
            'slug' => 'hmo-b',
            'email' => 'hmo_b@example.com',
            'code' => 'HMO-B',
            'batch_by_encounter_date' => false,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO C',
            'slug' => 'hmo-c',
            'email' => 'hmo_c@example.com',
            'code' => 'HMO-C',
            'batch_by_encounter_date' => true,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO D',
            'slug' => 'hmo-d',
            'email' => 'hmo_d@example.com',
            'code' => 'HMO-D',
            'batch_by_encounter_date' => false,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO E',
            'slug' => 'hmo-e',
            'email' => 'hmo_e@example.com',
            'code' => 'HMO-E',
            'batch_by_encounter_date' => true,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO F',
            'slug' => 'hmo-f',
            'email' => 'hmo_f@example.com',
            'code' => 'HMO-F',
            'batch_by_encounter_date' => false,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
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
