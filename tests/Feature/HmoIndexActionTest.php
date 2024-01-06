<?php

namespace Tests\Feature;

use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HmoIndexActionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Set up the test case.
     *
     * This method is called before each test method is executed.
     * It calls the parent's setUp method and seeds the HmoSeeder.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(HmoSeeder::class);
    }

    /**
     * Test the hmo_index_action method.
     *
     * @return void
     */
    public function test_hmo_index_action()
    {
        $response = $this->getJson('/api/hmos');

        $response->assertOk();

        $response->assertJsonCount(6, 'data');
    }
}
