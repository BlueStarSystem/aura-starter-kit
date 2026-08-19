<x-layouts.app title="Welcome">
    <div class="py-10 text-center">
        <x-aura::heading level="1">Your application starts here</x-aura::heading>

        <x-aura::text class="mx-auto mt-4 max-w-2xl">
            This page, the navigation above and the dashboard are built entirely from Aura UI
            components. Every colour comes from the token scale in <code>resources/css/app.css</code>:
            change it there and the whole application follows.
        </x-aura::text>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <x-aura::button href="{{ url('/dashboard') }}" variant="primary" size="lg">
                See the dashboard
            </x-aura::button>
            <x-aura::button href="https://aura-ui.com/components" variant="outline" size="lg">
                Browse the components
            </x-aura::button>
        </div>
    </div>

    <div class="mt-12 grid gap-6 sm:grid-cols-3">
        <x-aura::card>
            <x-aura::heading level="3">Own the code</x-aura::heading>
            <x-aura::text class="mt-2">
                <code>php artisan aura:add card</code> copies a component's source into your project.
                Keep the dependency or walk away with the files.
            </x-aura::text>
        </x-aura::card>

        <x-aura::card>
            <x-aura::heading level="3">Accessible by default</x-aura::heading>
            <x-aura::text class="mt-2">
                <code>php artisan aura:doctor --a11y</code> checks your own Blade templates against
                the same rules the library is tested with.
            </x-aura::text>
        </x-aura::card>

        <x-aura::card>
            <x-aura::heading level="3">Dark mode included</x-aura::heading>
            <x-aura::text class="mt-2">
                The switch in the navigation is a real component. Colours, shadows and glows adapt
                on their own.
            </x-aura::text>
        </x-aura::card>
    </div>
</x-layouts.app>
