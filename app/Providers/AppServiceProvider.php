<?php

namespace App\Providers;

use App\Domain\ShortUrl\Contracts\ShortUrlRepository;
use App\Infrastructure\Persistence\EloquentShortUrlRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ShortUrlRepository::class, EloquentShortUrlRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
