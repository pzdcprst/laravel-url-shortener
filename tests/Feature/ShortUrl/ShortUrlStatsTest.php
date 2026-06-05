<?php

namespace Tests\Feature\ShortUrl;

use App\Infrastructure\Persistence\Models\ClickModel;
use App\Infrastructure\Persistence\Models\ShortUrlModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShortUrlStatsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_requires_authentication(): void
    {
        $response = $this->getJson('/api/v1/short-urls/550e8400-e29b-41d4-a716-446655440000/stats');

        $response->assertUnauthorized();
    }

    #[Test]
    public function it_returns_click_statistics_for_owner(): void
    {
        $user = User::factory()->create();

        $shortUrl = ShortUrlModel::query()->create([
            'id' => '550e8400-e29b-41d4-a716-446655440000',
            'user_id' => $user->id,
            'original_url' => 'https://example.com',
            'short_code' => 'Ax7B2k1',
            'created_at' => now(),
        ]);

        ClickModel::query()->create([
            'id' => '660e8400-e29b-41d4-a716-446655440001',
            'short_url_id' => $shortUrl->id,
            'ip' => '10.0.0.1',
            'user_agent' => 'Test',
            'referer' => null,
            'created_at' => now(),
        ]);

        ClickModel::query()->create([
            'id' => '660e8400-e29b-41d4-a716-446655440002',
            'short_url_id' => $shortUrl->id,
            'ip' => '10.0.0.1',
            'user_agent' => 'Test',
            'referer' => null,
            'created_at' => now(),
        ]);

        ClickModel::query()->create([
            'id' => '660e8400-e29b-41d4-a716-446655440003',
            'short_url_id' => $shortUrl->id,
            'ip' => '10.0.0.2',
            'user_agent' => 'Test',
            'referer' => null,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($user)->getJson('/api/v1/short-urls/'.$shortUrl->id.'/stats');

        $response->assertOk()
            ->assertJsonPath('clicks', 3)
            ->assertJsonPath('unique_visitors', 2)
            ->assertJsonStructure(['last_click_at']);
    }

    #[Test]
    public function it_hides_stats_from_other_users(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $shortUrl = ShortUrlModel::query()->create([
            'id' => '550e8400-e29b-41d4-a716-446655440000',
            'user_id' => $owner->id,
            'original_url' => 'https://example.com',
            'short_code' => 'Ax7B2k1',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($other)->getJson('/api/v1/short-urls/'.$shortUrl->id.'/stats');

        $response->assertNotFound();
    }
}
