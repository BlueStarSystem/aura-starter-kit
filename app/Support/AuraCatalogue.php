<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Every component the installed Aura package actually ships.
 *
 * Read from the package's own registry rather than written down here. A list of
 * component names copied into a Blade file is correct on the day it is written
 * and wrong at the next release — and this page exists precisely to tell people
 * how much they get, so it is the last place that can afford to be out of date.
 *
 * The registry lives inside the installed package, so this needs no network and
 * always describes the version you have, not the version the docs describe.
 */
class AuraCatalogue
{
    private const REGISTRY = 'vendor/bluestarsystem/aura-ui/resources/aura-registry.json';

    /**
     * @return Collection<int, string>
     */
    public function components(): Collection
    {
        return $this->entries()
            ->filter(fn (array $entry) => ($entry['type'] ?? null) === 'component')
            ->keys()
            ->sort()
            ->values();
    }

    /**
     * @return Collection<int, string>
     */
    public function blocks(): Collection
    {
        return $this->entries()
            ->filter(fn (array $entry) => ($entry['type'] ?? null) === 'block')
            ->keys()
            ->sort()
            ->values();
    }

    /**
     * The documentation page for a component, where its description and props
     * live. Kept as a link rather than copied: the docs are generated from the
     * same registry the site publishes, and a description pasted here would be
     * one more thing to keep in step.
     */
    public function docsUrl(string $component): string
    {
        return 'https://aura-ui.com/docs/components/'.$component;
    }

    public function title(string $component): string
    {
        return str($component)->replace('-', ' ')->title()->toString();
    }

    /**
     * @return Collection<string, array<string, mixed>>
     */
    private function entries(): Collection
    {
        $path = base_path(self::REGISTRY);

        if (! is_file($path)) {
            return collect();
        }

        return collect(json_decode((string) file_get_contents($path), true) ?: []);
    }
}
