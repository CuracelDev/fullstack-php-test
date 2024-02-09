<?php

namespace Tests\Feature\Actions\Hmo;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetHmosTest extends TestCase
{
    public function testGetAllHmos()
    {
        $this->getJson(route('hmos.all'))
            ->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    ['id', 'code']
                ]
            ]);
    }
}
