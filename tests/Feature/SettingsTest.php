<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * The screens behind the account: what a person changes after signing up. The
 * endpoints are Fortify's, so what is worth testing is the seam — that our forms
 * post where Fortify listens, with the field names it expects.
 */
class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_settings_screens_are_closed_to_visitors(): void
    {
        $this->get('/settings/profile')->assertRedirect('/login');
        $this->get('/settings/password')->assertRedirect('/login');
        $this->get('/settings/two-factor')->assertRedirect('/login');
    }

    public function test_a_signed_in_user_sees_their_own_details(): void
    {
        $user = User::factory()->create(['name' => 'Giulia Bianchi', 'email' => 'giulia@example.com']);

        $this->actingAs($user)->get('/settings/profile')
            ->assertOk()
            ->assertSee('Giulia Bianchi', false)
            ->assertSee('giulia@example.com', false);
    }

    public function test_the_profile_can_be_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/profile-information', ['name' => 'Nuovo Nome', 'email' => 'nuovo@example.com'])
            ->assertSessionHasNoErrors();

        $this->assertSame('Nuovo Nome', $user->fresh()->name);
        $this->assertSame('nuovo@example.com', $user->fresh()->email);
    }

    public function test_the_password_can_be_changed_and_the_old_one_is_required(): void
    {
        $user = User::factory()->create(['password' => Hash::make('correct-horse-battery-staple')]);

        $this->actingAs($user)->put('/user/password', [
            'current_password' => 'wrong',
            'password' => 'a-brand-new-passphrase',
            'password_confirmation' => 'a-brand-new-passphrase',
        ])->assertSessionHasErrors();

        $this->assertTrue(Hash::check('correct-horse-battery-staple', $user->fresh()->password));

        $this->actingAs($user)->put('/user/password', [
            'current_password' => 'correct-horse-battery-staple',
            'password' => 'a-brand-new-passphrase',
            'password_confirmation' => 'a-brand-new-passphrase',
        ])->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('a-brand-new-passphrase', $user->fresh()->password));
    }

    /**
     * config/fortify.php asks for the password again before two-factor settings
     * may be touched. The page has to ask too, or it would show a secret the
     * endpoints then refuse to act on.
     */
    public function test_the_two_factor_page_asks_for_the_password_again(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/settings/two-factor')
            ->assertRedirect('/user/confirm-password');
    }

    public function test_two_factor_can_be_turned_on_and_shows_its_secret(): void
    {
        $user = User::factory()->create();

        // Enabling is itself behind the password confirmation, so a request
        // without it is redirected and quietly does nothing at all.
        $this->session(['auth.password_confirmed_at' => time()]);

        $this->actingAs($user)->post('/user/two-factor-authentication')->assertSessionHasNoErrors();

        /*
         * Not hasEnabledTwoFactorAuthentication(): with the confirm option on it
         * stays false until a code has been entered, which is exactly the trap
         * the page fell into — it keyed its state on that method and would have
         * offered "turn on" forever.
         */
        $this->assertNotNull($user->fresh()->two_factor_secret, 'Enabling should have produced a secret.');
        $this->assertNull($user->fresh()->two_factor_confirmed_at, 'It should wait for a code before counting as on.');

        $this->actingAs($user->fresh())->get('/settings/two-factor')
            ->assertOk()
            ->assertSee('Recovery codes')
            ->assertSee('<svg', false);
    }
}
