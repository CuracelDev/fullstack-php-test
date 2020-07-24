<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function products_can_be_viewed()
    {
        $this->withoutExceptionHandling();

        $users = factory(User::class, 2)->create();
        $response = $this->get('/api/users');

        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        'id' => $users->first()->id,
                        'name' => $users->first()->name,
                    ],
                    [
                        'id' => $users->last()->id,
                        'name' => $users->last()->name,
                    ],
                ],
            ]);
    }

}
