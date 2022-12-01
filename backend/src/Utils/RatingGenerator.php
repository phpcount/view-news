<?php

namespace App\Utils;

class RatingGenerator
{
    public static function get(): int
    {
        return rand(1, 10);
    }
}
