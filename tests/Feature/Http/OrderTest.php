<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_load_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_page_is_load()
    {
        $response = $this->get('/');

        $response->assertSee('Submit')->assertSuccessful();
    }
}
