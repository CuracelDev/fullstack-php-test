<?php
use App\Models\User;

if (!function_exists('access_token')) {
    function access_token()
    {
        return session()->get('access_token');
    }
}

if (!function_exists('user')) {
    function user(): User
    {
        return auth()->user();
    }
}
