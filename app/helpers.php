<?php

if (!function_exists('access_token')) {
    function access_token()
    {
        return session()->get('access_token');
    }
}
