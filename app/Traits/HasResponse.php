<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;

trait HasResponse
{
    public function successResponse(string $message, mixed $data = [], int $code = 200)
    {
        return new JsonResponse(
            [
                'status' => true,
                'message' => $message,
                'data' => $data
            ], 
            $code
        );
    }

    public function failedResponse(string $message, mixed $data = [], int $code = 400)
    {
        return response(
            [
                'status' => false,
                'message' => $message,
                'data' => $data
            ], 
            $code
        );
    }

    public function notExistResponse(string $message, int $code = 404)
    {
        return response(
            [
                'status' => false,
                'message' => $message
            ], 
            $code
        );
    }

    public function validationResponse(string $message, mixed $data, int $code = 422)
    {
        return response(
            [
                'status' => false,
                'message' => $message,
                'data' => $data
            ], 
            $code
        );
    }
}