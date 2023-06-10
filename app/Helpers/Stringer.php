<?php

namespace App\Helpers;

class Stringer
{
    /**
     * Finds whether the given variable is null or "".
     *
     * | $var | NULL | "" | 0 | "0" | 1 |
     * |-----------------|-------|-------|------|-------|------|
     * | !$var | TRUE | TRUE | TRUE | TRUE | FALSE|
     *
     * @param mixed $val
     * @return mixed
     */
    public static function is_null(mixed $val): mixed
    {
        return !$val;
    }
}
