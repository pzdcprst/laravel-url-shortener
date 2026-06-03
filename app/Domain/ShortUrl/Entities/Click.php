<?php

namespace App\Domain\ShortUrl\Entities;

use DateTimeImmutable;

final class Click
{
    public function __construct(
        public readonly string $id,
        public readonly string $shortUrlId,
        public readonly string $ip,
        public readonly ?string $userAgent,
        public readonly ?string $referer,
        public readonly DateTimeImmutable $createdAt,
    ) {}
}
