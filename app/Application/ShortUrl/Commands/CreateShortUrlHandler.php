<?php

namespace App\Application\ShortUrl\Commands;

use App\Application\ShortUrl\DTO\CreateShortUrlResult;
use App\Domain\ShortUrl\Contracts\ShortUrlRepository;
use App\Domain\ShortUrl\Entities\ShortUrl;
use App\Domain\ShortUrl\Services\ShortCodeGenerator;
use App\Domain\ShortUrl\ValueObjects\OriginalUrl;
use DateTimeImmutable;
use Illuminate\Support\Str;
use RuntimeException;

final class CreateShortUrlHandler
{
    private const MAX_ATTEMPTS = 10;

    public function __construct(
        private readonly ShortUrlRepository $repository,
        private readonly ShortCodeGenerator $codeGenerator,
    ) {}

    public function handle(string $url): CreateShortUrlResult
    {
        $originalUrl = new OriginalUrl($url);
        $length = (int) config('shortener.short_code_length', 7);

        for ($attempt = 0; $attempt < self::MAX_ATTEMPTS; $attempt++) {
            $shortCode = $this->codeGenerator->generate($length);

            if ($this->repository->existsByShortCode($shortCode)) {
                continue;
            }

            $shortUrl = new ShortUrl(
                id: (string) Str::uuid(),
                originalUrl: $originalUrl->value,
                shortCode: $shortCode,
                createdAt: new DateTimeImmutable,
            );

            $this->repository->save($shortUrl);

            return new CreateShortUrlResult(
                id: $shortUrl->id,
                shortUrl: rtrim(config('shortener.base_url'), '/').'/'.$shortUrl->shortCode,
                shortCode: $shortUrl->shortCode,
                originalUrl: $shortUrl->originalUrl,
            );
        }

        throw new RuntimeException('Could not generate a unique short code.');
    }
}
