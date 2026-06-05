<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function users_can_login_and_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'alice@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'alice@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertViewIs('dashboard');
    }

    #[Test]
    public function login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'alice@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'alice@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
