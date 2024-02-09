<?php

namespace Tests;

use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(HmoSeeder::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        gc_collect_cycles();
    }
}
