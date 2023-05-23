<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logError(Request $request, Exception $e)
    {
        $traceJson = json_encode($e->getTrace());
        Log::error(
            "[{$request->header('x-request-id')}] [{$e->getMessage()}] [{$e->getCode()}] [{$e->getFile()}] [{$e->getLine()}] [{$traceJson}]"
        );
    }
}
