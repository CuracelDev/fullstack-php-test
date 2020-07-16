<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Repositories\UserRepository;

class UserController extends Controller
{
    protected $user;

    public function __construct(
        UserRepository $user
    ) {
        $this->user = $user;
    }

    public function welcome() {
        return $this->success('Welcome to mini shop');
    }

    public function register(Request $request) {
 
    }

    public function login(Request $request) {
 
    }
}
