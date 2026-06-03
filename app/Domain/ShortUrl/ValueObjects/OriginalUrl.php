<?php

namespace App\Domain\ShortUrl\ValueObjects;

use InvalidArgumentException;

final readonly class OriginalUrl
{
    public function __construct(public string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL.');
        }

        if (! in_array(parse_url($value, PHP_URL_SCHEME), ['http', 'https'], true)) {
            throw new InvalidArgumentException('URL must use http or https.');
        }
    }
}
