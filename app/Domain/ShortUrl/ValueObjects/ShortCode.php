<?php

namespace App\Domain\ShortUrl\ValueObjects;

use InvalidArgumentException;

final readonly class ShortCode
{
    private const PATTERN = '/^[0-9a-zA-Z]{6,8}$/';

    public function __construct(public string $value)
    {
        if (! preg_match(self::PATTERN, $value)) {
            throw new InvalidArgumentException('Invalid short code format.');
        }
    }
}
