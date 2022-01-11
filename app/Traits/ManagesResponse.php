<?php


namespace App\Traits;


trait ManagesResponse
{
    public function coreResponse($message, $status, $code, $data = [])
    {
        if (!$message) return response()->json('Message cannot be empty!');

        if ($status == 'success') {
            return response()->json([
                'message' => $message,
                'data'    => $data,
                'status'  => $status,
                'code'    => $code,
            ]);
        } else {
            return response()->json([
                'message' => $message,
                'status'  => $status,
                'code'    => $code,
            ]);
        }
    }

    public function sendResponse($message, $data, $code = 200, $status = 'success')
    {
        return $this->coreResponse($message, $status, $code, $data);
    }

    public function sendErrors($message, $code, $status = 'error')
    {
        return $this->coreResponse($message, $status, $code);
    }
}