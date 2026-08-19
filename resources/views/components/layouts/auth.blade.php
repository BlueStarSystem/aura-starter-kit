<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        (() => {
            const stored = localStorage.getItem('theme');
            const dark = stored === 'dark' || (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <a href="{{ url('/') }}" class="mb-8">
            <x-aura::brand name="{{ config('app.name') }}" />
        </a>

        <div class="w-full max-w-md">
            <x-aura::card>
                <div class="mb-6">
                    <x-aura::heading level="1">{{ $heading }}</x-aura::heading>
                    @isset($subheading)
                        <x-aura::text class="mt-1 text-sm">{{ $subheading }}</x-aura::text>
                    @endisset
                </div>

                {{-- Fortify puts one-off messages in the session: a reset link sent, a
                     password changed. Without this the user submits a form and the page
                     comes back looking untouched. --}}
                @if (session('status'))
                    <x-aura::alert variant="success" class="mb-6">{{ session('status') }}</x-aura::alert>
                @endif

                {{ $slot }}
            </x-aura::card>

            @isset($footer)
                <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">{{ $footer }}</div>
            @endisset
        </div>
    </div>

    {{-- Alpine ships inside Livewire's bundle, and the auth screens need it as
         much as the rest of the app: without it the password field shows both
         its reveal icons at once and the two-factor screen cannot switch to the
         recovery-code form. --}}
    @livewireScripts
</body>
</html>
