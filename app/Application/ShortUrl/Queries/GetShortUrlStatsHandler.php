<?php

namespace App\Application\ShortUrl\Queries;

use App\Application\ShortUrl\DTO\ShortUrlStatsResult;
use App\Domain\ShortUrl\Contracts\ShortUrlRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetShortUrlStatsHandler
{
    public function __construct(
        private readonly ShortUrlRepository $repository,
    ) {}

    public function handle(string $id): ShortUrlStatsResult
    {
        if ($this->repository->findById($id) === null) {
            throw new NotFoundHttpException('Short URL not found.');
        }

        $stats = $this->repository->getStats($id);

        return new ShortUrlStatsResult(
            clicks: $stats['clicks'],
            uniqueVisitors: $stats['unique_visitors'],
            lastClickAt: $stats['last_click_at'],
        );
    }
}
