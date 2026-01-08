<?php

namespace App\Helper;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ApiResponse
{
    public static function success($data = null, $message = 'Success', $statusCode = Response::HTTP_OK)
    {
        $response = [
            'status' => 'success',
            'message' => $message,
        ];

        if ($data instanceof JsonResource || $data instanceof \Illuminate\Http\Resources\Json\AnonymousResourceCollection) {
            return $data->additional($response)->response()->setStatusCode($statusCode);
        }

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    public static function error($errors = null, $message = 'Error', $statusCode = Response::HTTP_BAD_REQUEST)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
