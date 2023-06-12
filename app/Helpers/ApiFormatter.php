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
        return [
            'message' => $message,
            'status_code' => $statusCode,
            'status' => $status,
        ];
    }

    /**
     * Create a formatted API response.
     *
     * @param  mixed $status
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $statusCode
     * @param  mixed $error
     * @return array
     */
    protected static function createResponse($status, $data, $message, $statusCode, $error = null)
    {
        return  [
            'meta' => self::createMetaResponse($message, $statusCode, $status),
            'data' => $data,
            'error' => $error
        ];
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
    public static function error($message = null, $statusCode = 500, $error = null)
    {
        switch ($statusCode) {
            case '400':
            case '404':
            case '422':
                $metaMsg = "BussinessError";
                break;
            default:
                $metaMsg = "Error";
                $message = EnvHelper::useProduction() ? "Somethings is wrong" : $message;
                break;
        }
        return self::createResponse($metaMsg, null, $message, $statusCode, $error);
    }
}
