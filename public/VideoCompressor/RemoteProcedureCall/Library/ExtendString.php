<?php

namespace VideoCompressor\RemoteProcedureCall\Library;

class ExtendString
{
    public static function reverse(string $value): string
    {
        // 平仮名などマルチバイトの文字列が渡ってきた場合でも文字化けしないようにする
        $chars = [];
        $len = mb_strlen($value);

        for($i = 0; $i < $len; $i++) {
            $chars[] = mb_substr($value, $i, 1);
        }

        return implode('', array_reverse($chars));
    }

    public static function validAnagram(string $val1, string $val2): bool
    {
        // 文字列から空白を削除
        $string1 = str_replace(' ', '', $val1);
        $string2 = str_replace(' ', '', $val2);

        // 文字列をすべて小文字に変換
        $string1 = strtolower($string1);
        $string2 = strtolower($string2);

        // 文字列の出現回数を保持するハッシュマップ（連想配列）を作成する
        $strCountHash1 = [];
        $strCountHash2 = [];

        // $val1 と $val2 の各文字の出現回数をカウントする
        for ($i = 0; $i < strlen($string1) ; $i++) {
            $char = $string1[$i];

            if(isset($strCountHash1[$char])) {
                $strCountHash1[$char]++;
            } else {
                $strCountHash1[$char] = 1;
            }
        }

        for ($i = 0; $i < strlen($string2) ; $i++) {
            $char = $string2[$i];

            if(isset($strCountHash2[$char])) {
                $strCountHash2[$char]++;
            } else {
                $strCountHash2[$char] = 1;
            }
        }

        // 2つの連想配列を比較して真偽値を返す
        if(count(array_diff_assoc($strCountHash1, $strCountHash2)) === 0 &&
           count(array_diff_assoc($strCountHash2, $strCountHash1)) === 0) {
            return true;
        } else {
            return false;
        }

    }

    public static function sort(array $strArry): array
    {
        return array_reverse($strArry);
    }
}
