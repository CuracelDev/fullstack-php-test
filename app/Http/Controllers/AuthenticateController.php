<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ManagesResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    use ManagesResponse;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) return $this->sendErrors($validator->errors()->first(), 422)
            ->setStatusCode(422);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = $user->id;
            $data = [
                'user' => $user,
                'token' => $token,
            ];
            return $this->sendResponse('Login successful', $data, 200)->setStatusCode(200);
        } else {
            return $this->sendErrors('Invalid email address', 403)->setStatusCode(403);
        }
    }
}
