<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Hmo;

class HmoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all()
    {
        Hmo::factory()->count(14)->create()->toArray();

        $response = $this->getJson('/api/hmos');

        $response->assertStatus(200);
    }

    public function test_send_notification()
    {
        $hmo = Hmo::factory()->count(1)->create()->toArray();

        $response = $this->postJson("/api/hmos/{$hmo[0]['id']}/notify",[]);

        $response->assertStatus(200);
    }
}
