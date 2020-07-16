<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use DB;
use Validator;

class UserRepository
{
    use CommonHelper;
    
    protected $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function login($data) {
    
    }

    public function register($data) {
        
    }
}
