<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // get all users
    public function index()
    {
        $user = User::get();

        return response($user, Response::HTTP_OK);
    }

    // get currently logged in user
    public function getCurrentLoggedInUser()
    {
        $user = Auth::user();

        return response($user, Response::HTTP_OK);
    }
}
