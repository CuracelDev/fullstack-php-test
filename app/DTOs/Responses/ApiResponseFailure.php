<?php

namespace App\DTOs\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;

class ApiResponseFailure extends DataTransferObject
{

    protected $message;
    protected $statusCode;

    public static function make(string $message, int $statusCode = 400): self
    {
        return new self([
            'message' => $message,
            'statusCode' => $statusCode
        ]);
    }


    public function toResponse($request): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'status' => 'failed',
                'message' => $this->message,
            ],
            $this->statusCode
        );
    }
}
