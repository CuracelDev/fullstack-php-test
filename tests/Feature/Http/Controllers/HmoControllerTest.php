<?php

namespace Tests\Feature\Http\Controllers;

use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HmoControllerTest extends TestCase
{
    /**
     * GET /api/hmos
     *
     * @test
     * @return void
     */
    public function can_get_all_hmos(): void
    {
        $this->seed(HmoSeeder::class);

        $this->getJson('/api/hmos')
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'name',
                        'code'
                    ],
                ],
                'message',
            ]);
    }
}
