<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }
}
