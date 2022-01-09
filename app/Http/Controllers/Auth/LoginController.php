<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    // Login user with jwt token and cookie
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        if (Auth::attempt($request->only('email','password'))) {
            $user = Auth::user();

            $token = $user->createToken('user')->accessToken;

            $cookie = cookie('jwt', $token, 7200);

            return response(['token' => $token], Response::HTTP_OK)->withCookie($cookie);
        }

        return response(["error" => "Email or Password do not match"], Response::HTTP_BAD_REQUEST);
    }
}
