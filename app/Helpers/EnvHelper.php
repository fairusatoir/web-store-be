<?php

namespace App\Helpers;

class EnvHelper
{
    /**
     * Checks the value of APP_ENV.
     *
     * @return string Message about the application environment.
     */
    public static function useProduction()
    {
        return env('APP_ENV') === 'production';
    }
}
