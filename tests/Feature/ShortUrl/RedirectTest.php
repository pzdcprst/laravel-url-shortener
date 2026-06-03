<?php

namespace Tests\Feature\ShortUrl;

use App\Infrastructure\Persistence\Models\ShortUrlModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_redirects_to_the_original_url_and_records_a_click(): void
    {
        $shortUrl = ShortUrlModel::query()->create([
            'id' => '550e8400-e29b-41d4-a716-446655440000',
            'original_url' => 'https://example.com/target',
            'short_code' => 'Ab12Cd3',
            'created_at' => now(),
        ]);

        $response = $this->get('/'.$shortUrl->short_code);

        $response->assertRedirect('https://example.com/target');
        $this->assertDatabaseHas('clicks', [
            'short_url_id' => $shortUrl->id,
        ]);
    }

    #[Test]
    public function it_returns_not_found_for_unknown_codes(): void
    {
        $response = $this->get('/ZZZZZZ');

        $response->assertNotFound();
    }
}
