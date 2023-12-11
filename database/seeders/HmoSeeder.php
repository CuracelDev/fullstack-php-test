<?php

namespace Database\Seeders;

use App\Enums\BatchRequirementEnum;
use Illuminate\Database\Seeder;
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
            ['name' => 'HMO A', 'code' => 'HMO-A', 'batch_requirement' => BatchRequirementEnum::SENT_DATE()->value, 'email' => 'hmoa@curacel.com'],
            ['name' => 'HMO B', 'code' => 'HMO-B', 'batch_requirement' => BatchRequirementEnum::SENT_DATE()->value, 'email' => 'hmob@curacel.com'],
            ['name' => 'HMO C', 'code' => 'HMO-C', 'batch_requirement' => BatchRequirementEnum::ENCOUNTER_DATE()->value, 'email' => 'hmca@curacel.com'],
            ['name' => 'HMO D', 'code' => 'HMO-D', 'batch_requirement' => BatchRequirementEnum::ENCOUNTER_DATE()->value, 'email' => 'hmod@curacel.com'],
        ];
        DB::table('hmos')->insert($hmos);
    }
}
