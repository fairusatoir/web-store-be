<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiFormatter
{
    /**
     * Create a formatted API response.
     *
     * @param  mixed $status
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $statusCode
     * @return void
     */
    protected static function createResponse($status, $data, $message, $statusCode): JsonResponse
    {
        return response()->json(
            [
                'resposne' => [
                    'data' => $data,
                    'meta' => [
                        'message' => $message,
                        'status_code' => $statusCode,
                        'status' => $status,
                    ]
                ]
            ]
        );
    }

    /**
     * Create a successful API response.
     *
     * @param mixed $data
     * @param array $meta
     * @return array
     */
    public static function success($data = null, $message = null, $statusCode = 200)
    {
        return self::createResponse('success', $data, $message, $statusCode);
    }


    /**
     * Create a error API response.
     *
     * @param  mixed $message
     * @param  mixed $statusCode
     * @return void
     */
    public static function error($message = null, $statusCode = 400)
    {
        return self::createResponse('error', null, $message, $statusCode);
    }
}
