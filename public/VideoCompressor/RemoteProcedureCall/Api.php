<?php

//public/VideoCompressor/RemoteProcedureCall/Api.php

namespace VideoCompressor\RemoteProcedureCall;

use Datto\JsonRpc\Evaluator;
use Datto\JsonRpc\Exceptions\MethodException;
use Datto\JsonRpc\Exceptions\ArgumentException;
use VideoCompressor\RemoteProcedureCall\Library\Math;
use Symfony\Component\String\Exception\InvalidArgumentException;
use VideoCompressor\RemoteProcedureCall\Library\ExtendString;

class Api implements Evaluator
{
    public function evaluate($method, $params)
    {
        
        if ($method === 'floor') {
            return self::floor((float)$params);
        }

        if($method === 'nroot') {
            return self::nroot($params[0], $params[1]);
        }

        if($method === 'reverse') {
            return self::reverse((string)$params);
        }

        if($method === 'validAnagram') {
            return self::validAnagram($params[0], $params[1]);
        }

        if($method === 'sort') {
            return self::sort($params);
        }

        throw new MethodException();
    }

    private static function floor(int $n): float
    {
        if (!is_int($n)) {
            throw new ArgumentException('数値に変換できませんでした。');
        }

        return Math::floor($n);
    }

    private static function nroot(int $n, int $x): int
    {

        if (!is_int($n) && !is_int($x)) {
            throw new ArgumentException('数値に変換できませんでした。');
        }

        if($n <= 0) {
            throw new InvalidArgumentException('引数が不正な値です。');
        }

        if($x < 0) {
            throw new InvalidArgumentException('引数が不正な値です。');
        }

        return Math::nroot($n, $x);
    }

    private static function reverse(string $value): string
    {
        return ExtendString::reverse($value);
    }

    private static function validAnagram(string $str1, string $str2): bool
    {
        return ExtendString::validAnagram($str1, $str2);
    }

    private static function sort(array $strArry): array
    {
        return ExtendString::sort($strArry);
    }
}
