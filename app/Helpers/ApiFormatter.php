<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiFormatter
{
    /**
     * Create a Meta API response
     *
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $statusCode
     * @return array
     */
    protected static function createMetaResponse($message, $statusCode, $status): array
    {
        $meta = [
            'message' => $message,
            'status_code' => $statusCode,
            'status' => $status,
        ];

        return $meta;
    }

    /**
     * Create a formatted API response.
     *
     * @param  mixed $status
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $statusCode
     * @return array
     */
    protected static function createResponse($status, $data, $message, $statusCode)
    {
        $response = [
            'meta' => self::createMetaResponse($message, $statusCode, $status),
            'data' => $data,
        ];

        return $response;
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
     * @return array
     */
    public static function error($message = null, $statusCode = 500)
    {
        switch ($statusCode) {
            case '404':
                $meta_msg = "BussinessError";
                break;
            default:
                $meta_msg = "Error";
                $message = EnvHelper::useProduction() ? "Somethings is wrong" : $message;
                break;
        }
        return self::createResponse($meta_msg, null, $message, $statusCode);
    }
}
