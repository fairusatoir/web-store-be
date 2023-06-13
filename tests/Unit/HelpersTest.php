<?php

namespace Tests\Unit;

use App\Helpers\Stringer;
use App\Helpers\EnvHelper;
use Illuminate\Support\Env;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    /**
     * Test the is_null method in Stringer class.
     */
    public function test_Stringer_null_checker(): void
    {
        $hlp = new Stringer();
        $this->assertTrue($hlp->isNull(""));
        $this->assertTrue($hlp->isNull(null));
    }

    /**
     * Test the useProduction method in EnvHelper class.
     */
    public function test_EnvHelper_check_use_env_production(): void
    {
        $actualEnv = env('APP_ENV');
        $hlp = new EnvHelper();

        if ($actualEnv === "production") {
            $this->assertTrue($hlp->useProduction(""));
        } else {
            $this->assertFalse($hlp->useProduction(""), "Your Env is {$actualEnv}");
        }
    }
}
