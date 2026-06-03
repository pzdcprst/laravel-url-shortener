<?php

namespace App\Application\ShortUrl\Commands;

use App\Domain\ShortUrl\Contracts\ShortUrlRepository;
use App\Domain\ShortUrl\Entities\Click;
use App\Domain\ShortUrl\ValueObjects\ShortCode;
use DateTimeImmutable;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class RecordClickHandler
{
    public function __construct(
        private readonly ShortUrlRepository $repository,
    ) {}

    public function handle(string $shortCode, string $ip, ?string $userAgent, ?string $referer): string
    {
        $shortUrl = $this->repository->findByShortCode(new ShortCode($shortCode));

        if ($shortUrl === null) {
            throw new NotFoundHttpException('Short URL not found.');
        }

        $this->repository->recordClick(new Click(
            id: (string) Str::uuid(),
            shortUrlId: $shortUrl->id,
            ip: $ip,
            userAgent: $userAgent,
            referer: $referer,
            createdAt: new DateTimeImmutable,
        ));

        return $shortUrl->originalUrl;
    }
}
