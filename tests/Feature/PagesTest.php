<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The pages the starter kit ships must render. Every component on them is a
 * real Aura tag with real props: a typo in either is a fatal Blade error, so
 * this is the cheapest guard against shipping a kit that does not boot.
 */
class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_welcome_page_renders(): void
    {
        $this->get('/')->assertOk()->assertSee('Your application starts here');
    }

    public function test_the_dashboard_renders_for_a_signed_in_user(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_the_components_overview_renders_every_component_from_the_registry(): void
    {
        $catalogue = app(\App\Support\AuraCatalogue::class);
        $components = $catalogue->components();

        $this->assertGreaterThan(100, $components->count(), 'The package registry was not read.');

        $html = $this->get('/components')->assertOk()->getContent();

        // The count is stated on the page; it must be the registry's, not a number
        // someone typed. If a release adds a component, this follows on its own.
        $this->assertStringContainsString($components->count().' components', $html);

        // Spot-check both ends of the alphabet so a truncated loop is caught.
        $this->assertStringContainsString($catalogue->title($components->first()), $html);
        $this->assertStringContainsString($catalogue->title($components->last()), $html);
    }

    public function test_the_overview_states_no_component_count_by_hand(): void
    {
        $source = (string) file_get_contents(resource_path('views/components-overview.blade.php'));

        $this->assertDoesNotMatchRegularExpression(
            '/\d{2,3}\+?\s+(free\s+)?components?/i',
            $source,
            'The overview states a component count as a literal. Use $components->count().',
        );
    }

    public function test_the_pages_use_aura_components(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('aura-btn', $html, 'The Aura button did not render its own classes.');
        $this->assertStringNotContainsString('x-aura::', $html, 'An Aura tag was output literally instead of being compiled.');
    }
}
