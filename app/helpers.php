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

if (!function_exists('generateReference')) {
    /**
     * Generate a reference string without database check
     *
     * @param int $length Length of the reference string
     * @return string
     */
    function generateReference($length = 12): string
    {
        // Define characters pool for the reference string
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Initialize random string
        $randomString = '';

        // Generate random bytes securely
        $bytes = random_bytes($length);

        // Generate random string from bytes
        for ($i = 0; $i < $length; $i++) {
            // Convert byte to index
            $index = ord($bytes[$i]) % strlen($characters);
            // Append character to random string
            $randomString .= $characters[$index];
        }

        // Convert random string to uppercase
        $randomString = strtoupper($randomString);

        return $randomString;
    }
}





