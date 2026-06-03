<?php

namespace App\Application\ShortUrl\DTO;

final readonly class ShortUrlStatsResult
{
    public function __construct(
        public int $clicks,
        public int $uniqueVisitors,
        public ?string $lastClickAt,
    ) {}
}
