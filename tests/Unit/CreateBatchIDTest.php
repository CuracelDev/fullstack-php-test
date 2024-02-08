<?php

namespace Tests\Unit;

use App\Actions\Orders\CreateBatchID;
use PHPUnit\Framework\TestCase;

class CreateBatchIDTest extends TestCase
{
    public function testBatchID()
    {
        $provider = 'Provider XY';
        $date = now();

        $batchId = CreateBatchID::run($provider, $date);

        $this->assertEquals("$provider $date->shortMonthName $date->year", $batchId);
    }
}
