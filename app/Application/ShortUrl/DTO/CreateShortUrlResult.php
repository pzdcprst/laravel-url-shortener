<?php

namespace App\Application\ShortUrl\DTO;

final readonly class CreateShortUrlResult
{
    public function __construct(
        public string $id,
        public string $shortUrl,
        public string $shortCode,
        public string $originalUrl,
    ) {}
}
