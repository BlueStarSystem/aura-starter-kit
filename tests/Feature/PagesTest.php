<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * The two pages the starter kit ships must render. Every component on them is
 * a real Aura tag with real props: a typo in either is a fatal Blade error, so
 * this is the cheapest guard against shipping a kit that does not boot.
 */
class PagesTest extends TestCase
{
    public function test_the_welcome_page_renders(): void
    {
        $this->get('/')->assertOk()->assertSee('Your application starts here');
    }

    public function test_the_dashboard_renders(): void
    {
        $this->get('/dashboard')->assertOk()->assertSee('Dashboard');
    }

    public function test_the_pages_use_aura_components(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('aura-btn', $html, 'The Aura button did not render its own classes.');
        $this->assertStringNotContainsString('x-aura::', $html, 'An Aura tag was output literally instead of being compiled.');
    }
}
