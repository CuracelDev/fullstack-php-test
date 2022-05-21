<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User as Provider;

class ProviderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all()
    {
        Provider::factory()->count(14)->create()->toArray();

        $response = $this->getJson('/api/providers');

        $response->assertStatus(200);
    }
}
