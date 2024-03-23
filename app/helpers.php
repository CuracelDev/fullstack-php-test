<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;


if (! function_exists('successResponse')) {
    /**
     * Return a standard success json response
     */
    function successResponse($data = [], int $code = 200) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data
        ], $code);
    }
}

if (! function_exists('errorResponse')) {
    /**
     * Return a standard error json response
     */
    function errorResponse(string $message, int $code = 400, MessageBag $errors = null) : JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}

if (! function_exists('generateReference')) {
    /**
     * return a reference
     */
    function generateReference($length = 8)
    {
        // Generate a random string using alphanumeric characters
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}





