<?php

namespace App\Concerns;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait UsesCustomResponse
{
    public function success(
        string $message,
        mixed $data = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(
            data: ['success' => true, 'data' => $data, 'message' => $message],
            status: $statusCode
        );
    }

    public function error(string $message, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse(
            data: ['success' => false, 'message' => $message],
            status: $statusCode
        );
    }
}
