<?php

namespace App\Helpers;

class Base62 {
    private const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private static function encode(int $num): string
    {
        if ($num === 0) {
            return '0';
        }

        $base = strlen(self::CHARS);
        $str = '';

        while ($num > 0) {
            $str = self::CHARS[$num % $base] . $str;
            $num = intdiv($num, $base);
        }

        return $str;
    }
    public static function generateShortUrl() : string {
        // Generate a random ID. 62^7 is ~3.5 trillion combinations.
        $randomId = mt_rand(100000, 3500000000000);
        return self::encode($randomId);
    }
}
