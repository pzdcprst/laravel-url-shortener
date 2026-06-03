<?php

namespace App\Domain\ShortUrl\Services;

final class ShortCodeGenerator
{
    private const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function generate(int $length = 7): string
    {
        $maxIndex = strlen(self::ALPHABET) - 1;
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= self::ALPHABET[random_int(0, $maxIndex)];
        }

        return $code;
    }

    public static function encode(int $number): string
    {
        if ($number === 0) {
            return '0';
        }

        $alphabet = self::ALPHABET;
        $base = strlen($alphabet);
        $result = '';

        while ($number > 0) {
            $result = $alphabet[$number % $base].$result;
            $number = intdiv($number, $base);
        }

        return $result;
    }
}
