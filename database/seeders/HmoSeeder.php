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
            'is_batched' => true,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO B',
            'slug' => 'hmo-b',
            'email' => 'hmo_b@example.com',
            'code' => 'HMO-B',
            'is_batched' => false,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO C',
            'slug' => 'hmo-c',
            'email' => 'hmo_c@example.com',
            'code' => 'HMO-C',
            'is_batched' => true,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO D',
            'slug' => 'hmo-d',
            'email' => 'hmo_d@example.com',
            'code' => 'HMO-D',
            'is_batched' => false,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO E',
            'slug' => 'hmo-e',
            'email' => 'hmo_e@example.com',
            'code' => 'HMO-E',
            'is_batched' => true,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ],
        [
            'name' => 'HMO F',
            'slug' => 'hmo-f',
            'email' => 'hmo_f@example.com',
            'code' => 'HMO-F',
            'is_batched' => false,
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
