<?php

namespace VideoCompressor\RemoteProcedureCall\Library;

class Math
{
    public static function floor($a): float
    {
        return floor($a);
    }

    public static function nroot(int $n, int $x): mixed
    {
        return pow($x, (1 / $n));
    }
}
