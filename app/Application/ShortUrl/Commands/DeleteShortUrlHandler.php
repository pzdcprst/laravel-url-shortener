<?php

namespace App\Application\ShortUrl\Commands;

use App\Domain\ShortUrl\Contracts\ShortUrlRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DeleteShortUrlHandler
{
    public function __construct(
        private readonly ShortUrlRepository $repository,
    ) {}

    public function handle(
        string $shortUrlId,
        int $userId,
    ): void {
        $deleted = $this->repository
            ->deleteForUser($shortUrlId, $userId);

        if (! $deleted) {
            throw new NotFoundHttpException(
                'Short URL not found.'
            );
        }
    }
}