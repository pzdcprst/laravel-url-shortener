<?php

namespace App\Domain\ShortUrl\Entities;

use DateTimeImmutable;

final class ShortUrl
{
    public function __construct(
        public readonly string $id,
        public readonly int $userId,
        public readonly string $originalUrl,
        public readonly string $shortCode,
        public readonly DateTimeImmutable $createdAt,
    ) {}
}
