<x-layouts.app title="Dashboard">
    <x-aura::heading level="1">Dashboard</x-aura::heading>
    <x-aura::text class="mt-2">A starting point, not a demo: delete what you do not need.</x-aura::text>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <x-aura::stats-card title="Users" value="1,284" />
        <x-aura::stats-card title="Revenue" value="€12,480" />
        <x-aura::stats-card title="Orders" value="312" />
        <x-aura::stats-card title="Refunds" value="4" />
    </div>

    <x-aura::card class="mt-8">
        <x-aura::heading level="3">Next steps</x-aura::heading>
        <x-aura::text class="mt-2">
            Visit <code>/aura/playground</code> to browse every component running in this
            application, or read the documentation at
            <x-aura::link href="https://aura-ui.com">aura-ui.com</x-aura::link>.
        </x-aura::text>
    </x-aura::card>
</x-layouts.app>
