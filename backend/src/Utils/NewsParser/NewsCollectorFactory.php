<?php

namespace App\Utils\NewsParser;

class NewsCollectorFactory
{
    public const SOURCE_RBC = 'rbc';

    public static function makeNews(string $type, array $args): AbstractPostListParser
    {
        switch (strtolower($type)):
            case self::SOURCE_RBC:
                return new RBCNewsParser\RBCPostListParser(...$args);
                break;
            default:
                throw new \RuntimeException('incorrect type of source news.');
        endswitch;
    }
}
