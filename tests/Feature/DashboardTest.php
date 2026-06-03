<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    #[Test]
    public function it_renders_the_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertViewIs('dashboard')
            ->assertSee('Сократите ссылку', false);
    }
}
