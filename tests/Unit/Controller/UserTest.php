<?php

namespace Tests\Unit\Controller;
use App\Http\Repositories\UserRepository;
use App\Models\User;
use Tests\TestCase;
use JWTAuth;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    protected $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = app()->make(UserRepository::class);
    }
    
    public function getTokenForUser(User $user) : string {
        return JWTAuth::fromUser($user);
    }

    public function testRegisterUser() {
        $data = factory(User::class)->create();
        $this->post('/api/v1/register', $data->toArray())
            ->assertStatus(201);
    }

    public function testLoginUser() {
        $data = [ 
            'email' => 'ayodeleoniosun@gmail.com',
            'password' => 'password',
        ];
        
        $this->post('/api/v1/login', $data)
            ->assertStatus(200);
    }
    
}
