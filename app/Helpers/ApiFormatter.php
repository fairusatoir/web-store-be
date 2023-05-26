<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiFormatter
{
    /**
     * Get the pagination attributes from the given paginated items.
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $items The paginated items.
     *
     * @return array The pagination attributes.
     */
    protected static function getPageAttr($items, $meta)
    {
        $pagination_attributes = [
            'meta' => $meta,
            'data' => $items->items(),
            'current_page' => $items->currentPage(),
            'first_page_url' => $items->url(1),
            'from' => $items->firstItem(),
            'last_page' => $items->lastPage(),
            'last_page_url' => $items->url($items->lastPage()),
            'next_page_url' => $items->nextPageUrl(),
            'path' => $items->path(),
            'per_page' => $items->perPage(),
            'prev_page_url' => $items->previousPageUrl(),
            'to' => $items->lastItem(),
            'total' => $items->total(),
        ];

        return $pagination_attributes;
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
        $meta = [
            'message' => $message,
            'status_code' => $statusCode,
            'status' => $status,
        ];
        return self::getPageAttr($data, $meta);
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
    public static function error($message = null, $statusCode = 400)
    {
        return self::createResponse('error', null, $message, $statusCode);
    }
}
