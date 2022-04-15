<?php

namespace Tests\Unit\Actions;

use App\Actions\GetBatchName;
use App\Models\Hmo;
use Carbon\Carbon;
use Tests\TestCase;

class GetBatchNameTest extends TestCase
{
    /**
     * @test
    */
    public function get_batch_name_for_provider_by_month()
    {
        $hmo = Hmo::factory()->create([
            'batch_by' => Hmo::BATCH_BY_MONTH
        ]);

        $actual = app()->make(GetBatchName::class)->handle($hmo, '2021-05-04', 'Provider One');

        $this->assertEquals("Provider One May 2021", $actual);
    }

    /**
    * @test
    */
    public function get_batch_name_for_provider_by_day()
    {
        $hmo = Hmo::factory()->create([
            'batch_by' => Hmo::BATCH_BY_DAY
        ]);

        $actual = app()->make(GetBatchName::class)->handle($hmo, '2021-05-04', 'Provider One');

        $batch = Carbon::now()->monthName . " " . Carbon::now()->year;

        $this->assertEquals("Provider One $batch", $actual);
    }
}
