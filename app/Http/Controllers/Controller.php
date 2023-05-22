<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logError(String $uuid, Exception $e)
    {

        $traceJson = json_encode($e->getTrace());
        Log::error(
            "[{$uuid}] [{$e->getMessage()}] [{$e->getCode()}] [{$e->getFile()}] [{$e->getLine()}] [{$traceJson}]"
        );
    }
}
