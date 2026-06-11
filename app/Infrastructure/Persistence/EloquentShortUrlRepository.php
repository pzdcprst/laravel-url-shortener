<?php

namespace App\Infrastructure\Persistence;

use App\Domain\ShortUrl\Contracts\ShortUrlRepository;
use App\Domain\ShortUrl\Entities\Click;
use App\Domain\ShortUrl\Entities\ShortUrl;
use App\Domain\ShortUrl\ValueObjects\ShortCode;
use App\Infrastructure\Persistence\Models\ClickModel;
use App\Infrastructure\Persistence\Models\ShortUrlModel;
use DateTimeImmutable;

final class EloquentShortUrlRepository implements ShortUrlRepository
{
    public function save(ShortUrl $shortUrl): void
    {
        ShortUrlModel::query()->create([
            'id' => $shortUrl->id,
            'user_id' => $shortUrl->userId,
            'original_url' => $shortUrl->originalUrl,
            'short_code' => $shortUrl->shortCode,
            'created_at' => $shortUrl->createdAt,
        ]);
    }

    public function findById(string $id): ?ShortUrl
    {
        $model = ShortUrlModel::query()->find($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function findByIdForUser(string $id, int $userId): ?ShortUrl
    {
        $model = ShortUrlModel::query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function findByShortCode(ShortCode $shortCode): ?ShortUrl
    {
        $model = ShortUrlModel::query()
            ->where('short_code', $shortCode->value)
            ->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function existsByShortCode(string $shortCode): bool
    {
        return ShortUrlModel::query()
            ->where('short_code', $shortCode)
            ->exists();
    }

    public function recordClick(Click $click): void
    {
        ClickModel::query()->create([
            'id' => $click->id,
            'short_url_id' => $click->shortUrlId,
            'ip' => $click->ip,
            'user_agent' => $click->userAgent,
            'referer' => $click->referer,
            'created_at' => $click->createdAt,
        ]);
    }

    public function getStats(string $shortUrlId): array
    {
        $query = ClickModel::query()->where('short_url_id', $shortUrlId);

        $clicks = (clone $query)->count();
        $uniqueVisitors = (clone $query)->distinct('ip')->count('ip');
        $lastClick = (clone $query)->max('created_at');

        return [
            'clicks' => $clicks,
            'unique_visitors' => $uniqueVisitors,
            'last_click_at' => $lastClick
                ? (new DateTimeImmutable($lastClick))->format('d.m.Y H:i:s')
                : null,
        ];
    }

    public function deleteForUser(string $id, int $userId): bool
    {
    return ShortUrlModel::query()
        ->where('id', $id)
        ->where('user_id', $userId)
        ->delete() > 0;
    }

    private function toEntity(ShortUrlModel $model): ShortUrl
    {
        return new ShortUrl(
            id: $model->id,
            userId: $model->user_id,
            originalUrl: $model->original_url,
            shortCode: $model->short_code,
            createdAt: $model->created_at,
        );
    }
}
