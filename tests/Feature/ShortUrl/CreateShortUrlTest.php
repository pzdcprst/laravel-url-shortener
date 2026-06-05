<?php

namespace Tests\Feature\ShortUrl;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateShortUrlTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_requires_authentication(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://example.com/article',
        ]);

        $response->assertUnauthorized();
    }

    #[Test]
    public function it_creates_a_short_url_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/short-urls', [
            'url' => 'https://example.com/article',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['id', 'short_url', 'original_url'])
            ->assertJsonPath('original_url', 'https://example.com/article');

        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com/article',
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function it_rejects_invalid_urls(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/short-urls', [
            'url' => 'not-a-url',
        ]);

        $response->assertUnprocessable();
    }
}
