<?php

namespace Tests\Feature\ShortUrl;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateShortUrlTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_short_url(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://example.com/article',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['id', 'short_url', 'original_url'])
            ->assertJsonPath('original_url', 'https://example.com/article');

        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com/article',
        ]);
    }

    #[Test]
    public function it_rejects_invalid_urls(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'not-a-url',
        ]);

        $response->assertUnprocessable();
    }
}
