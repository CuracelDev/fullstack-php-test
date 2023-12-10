<?php

namespace App\DTOs\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;

class ApiResponseSuccess extends DataTransferObject implements Responsable
{
    public $message;

    public $data;

    public $topLevelData;

    public $statusCode;

    public static function make(
        string $message,
        array $data = [],
        array $topLevelData = [],
        int $statusCode = 200
    ): self {
        return new self([
            'message' => $message,
            'data' => $data,
            'topLevelData' => $topLevelData,
            'statusCode' => $statusCode
        ]
        );
    }

    public function toResponse($request): JsonResponse
    {
        $var = [
            'status' => 'success',
        ];

        if ($this->message) {
            $var['message'] = $this->message;
        }

        if (count($this->topLevelData) > 0) {
            foreach ($this->topLevelData as $key => $item) {
                $var[$key] = $item;
            }
        }

        if (count($this->data) > 0) {
            $var['result']['data'] = $this->data;
        }

        return response()->json(
            $var,
            $this->statusCode
        );
    }
}
