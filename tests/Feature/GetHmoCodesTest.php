<?php

namespace Tests\Feature;

use App\Models\Hmo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetHmoCodesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_success_response_is_received(): void
    {
        $response = $this->getJson('/api/hmos');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_returns_correct_json_response_structure(): void
    {
        $response = $this->getJson('/api/hmos');

        $response->assertJsonStructure([
            'data',
            'success',
            'message'
        ]);
    }

    /** @test */
    public function it_returns_correct_json_values(): void
    {
        $hmos = Hmo::get()->pluck('code')->toArray();

        $response = $this->getJson('/api/hmos');

        $response->assertJson([
            'data' => $hmos, 
            'success' => true, 
            'message' => 'Hmos Code Retrived'
        ]);
    }
}
