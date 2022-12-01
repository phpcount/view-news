<?php

namespace App\Utils;

class Str
{
    public static function shortText(string $str, $maxLength = 100): string
    {
        return strlen($str) > $maxLength
            ? mb_substr($str, 0, $maxLength - 3) . '...'
            : $str;
    }
}
