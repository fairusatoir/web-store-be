<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logError(Request $request, Exception $e)
    {
        $traceJson = json_encode($e->getTrace());
        $headers = json_encode($request->header());
        $body = json_encode($request->all());
        Log::error([
            'request-id' => $request->header('x-request-id'),
            'message' => "[ERROR] " . $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'header' => $headers,
            'body' => $body,
            'trace' => $traceJson
        ]);
    }

    public function logInfo(Request $request, $data)
    {
        $headers = json_encode($request->header());
        $body = json_encode($request->all());
        Log::info([
            'request-id' => $request->header('x-request-id'),
            'message' => "[SUCCESS] ",
            'data' => $data,
            'header' => $headers,
            'body' => $body,
        ]);
    }
}
