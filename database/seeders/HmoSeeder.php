<?php

namespace Database\Seeders;

use App\Models\Hmo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        [
            'name' => 'HMO A',
            'email' => 'hmo_a@example.com',
            'code' => 'HMO-A',
            'batch_preference' => Hmo::BATCH_PREFERENCE_CREATED_DATE,
        ],
        [
            'name' => 'HMO B',
            'email' => 'hmo_b@example.com',
            'code' => 'HMO-B',
            'batch_preference' => Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE,
        ],
        [
            'name' => 'HMO C',
            'email' => 'hmo_c@example.com',
            'code' => 'HMO-C',
            'batch_preference' => Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE,
        ],
        [
            'name' => 'HMO D',
            'email' => 'hmo_d@example.com',
            'code' => 'HMO-D',
            'batch_preference' => Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE,
        ],
        [
            'name' => 'HMO E',
            'email' => 'hmo_e@example.com',
            'code' => 'HMO-E',
            'batch_preference' => Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE,
        ],
        [
            'name' => 'HMO F',
            'email' => 'hmo_f@example.com',
            'code' => 'HMO-F',
            'batch_preference' => Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('hmos')->insert($this->hmos);
    }
}
