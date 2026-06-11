<?php

namespace App\Domain\ShortUrl\Contracts;

use App\Domain\ShortUrl\Entities\Click;
use App\Domain\ShortUrl\Entities\ShortUrl;
use App\Domain\ShortUrl\ValueObjects\ShortCode;

interface ShortUrlRepository
{
    public function save(ShortUrl $shortUrl): void;

    public function findById(string $id): ?ShortUrl;

    public function findByIdForUser(string $id, int $userId): ?ShortUrl;

    public function findByShortCode(ShortCode $shortCode): ?ShortUrl;

    public function existsByShortCode(string $shortCode): bool;

    public function recordClick(Click $click): void;

    public function deleteForUser(string $id, int $userId): bool;

    /**
     * @return array{clicks: int, unique_visitors: int, last_click_at: ?string}
     */
    public function getStats(string $shortUrlId): array;
}
