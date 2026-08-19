<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{--
        Dark mode is decided before the first paint. Reading the stored choice
        after the stylesheet would show a white flash on every load for anyone
        who picked dark, which is the one thing a theme switch must never do.
    --}}
    <script>
        (() => {
            const stored = localStorage.getItem('theme');
            const dark = stored === 'dark' || (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">
    <x-aura::navbar sticky>
        <x-slot:brand>
            <x-aura::brand name="{{ config('app.name') }}" href="{{ url('/') }}" />
        </x-slot:brand>

        <x-slot:items>
            <x-aura::navbar.item href="{{ url('/') }}" :active="request()->is('/')">Home</x-aura::navbar.item>
            <x-aura::navbar.item href="{{ url('/components') }}" :active="request()->is('components')">Components</x-aura::navbar.item>
            @auth
                <x-aura::navbar.item href="{{ url('/dashboard') }}" :active="request()->is('dashboard')">Dashboard</x-aura::navbar.item>
            @endauth
        </x-slot:items>

        <x-slot:actions>
            <x-aura::theme-controller />

            @auth
                <x-aura::dropdown>
                    <x-slot:trigger>
                        <x-aura::button variant="ghost" size="sm">{{ auth()->user()->name }}</x-aura::button>
                    </x-slot:trigger>

                    <x-aura::dropdown.item href="{{ url('/dashboard') }}" icon="home">Dashboard</x-aura::dropdown.item>
                    <x-aura::dropdown.separator />
                    {{-- Signing out is a state change, so it is a POST with a token,
                         never a link someone can be tricked into following. --}}
                    <x-aura::dropdown.item
                        icon="lock"
                        x-on:click="document.getElementById('logout-form').submit()"
                    >Sign out</x-aura::dropdown.item>
                </x-aura::dropdown>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
            @else
                <x-aura::button href="{{ route('login') }}" variant="ghost" size="sm">Sign in</x-aura::button>
                <x-aura::button href="{{ route('register') }}" variant="primary" size="sm">Get started</x-aura::button>
            @endauth
        </x-slot:actions>

        <x-slot:mobile>
            <x-aura::navbar.item href="{{ url('/') }}" :active="request()->is('/')">Home</x-aura::navbar.item>
            <x-aura::navbar.item href="{{ url('/components') }}" :active="request()->is('components')">Components</x-aura::navbar.item>
            <x-aura::navbar.item href="{{ url('/dashboard') }}" :active="request()->is('dashboard')">Dashboard</x-aura::navbar.item>
        </x-slot:mobile>
    </x-aura::navbar>

    <main class="py-10">
        <x-aura::container>
            {{ $slot }}
        </x-aura::container>
    </main>

    @livewireScripts
</body>
</html>
