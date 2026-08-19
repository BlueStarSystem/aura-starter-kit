<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Fortify owns the routes and the logic; this kit owns the screens. These tests
 * cover the seam between the two — a view callback that is not registered fails
 * as a container binding error at request time, not at boot, so nothing but a
 * request through the real routes would catch it.
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_auth_screens_render(): void
    {
        $this->get('/login')->assertOk()->assertSee('Sign in');
        $this->get('/register')->assertOk()->assertSee('Create your account');
        $this->get('/forgot-password')->assertOk()->assertSee('Reset your password');
    }

    public function test_a_visitor_can_register_and_lands_authenticated(): void
    {
        $response = $this->post('/register', [
            'name' => 'Giulia Bianchi',
            'email' => 'giulia@example.com',
            'password' => 'correct-horse-battery-staple',
            'password_confirmation' => 'correct-horse-battery-staple',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'giulia@example.com']);
    }

    public function test_a_registered_user_can_sign_in(): void
    {
        $user = User::factory()->create([
            'email' => 'marco@example.com',
            'password' => Hash::make('correct-horse-battery-staple'),
        ]);

        $this->post('/login', [
            'email' => 'marco@example.com',
            'password' => 'correct-horse-battery-staple',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_wrong_password_is_rejected(): void
    {
        User::factory()->create([
            'email' => 'marco@example.com',
            'password' => Hash::make('correct-horse-battery-staple'),
        ]);

        $this->from('/login')
            ->post('/login', ['email' => 'marco@example.com', 'password' => 'wrong'])
            ->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_signing_out_requires_a_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout')->assertRedirect();
        $this->assertGuest();
    }

    public function test_the_dashboard_is_closed_to_visitors(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');

        $this->actingAs(User::factory()->create())->get('/dashboard')->assertOk();
    }

    /**
     * The public pages must stay public: a starter kit that hides its own
     * component overview behind a login shows nothing to the person deciding
     * whether to use it.
     */
    public function test_the_public_pages_stay_public(): void
    {
        $this->get('/')->assertOk();
        $this->get('/components')->assertOk();
    }

    public function test_a_password_reset_link_can_be_requested(): void
    {
        User::factory()->create(['email' => 'marco@example.com']);

        $this->post('/forgot-password', ['email' => 'marco@example.com'])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('password_reset_tokens', ['email' => 'marco@example.com']);
    }
}
