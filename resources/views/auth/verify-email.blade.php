<x-layouts.auth title="Verify your email" heading="Verify your email">
    <x-slot:subheading>We sent a link to the address you signed up with.</x-slot:subheading>

    @if (session('status') === 'verification-link-sent')
        <x-aura::alert variant="success" class="mb-6">A new link is on its way.</x-aura::alert>
    @endif

    <x-aura::text class="mb-6 text-sm">
        Click the link in that email to finish. If it never arrives, we can send another.
    </x-aura::text>

    <div class="flex flex-wrap items-center gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-aura::button type="submit" variant="primary">Send it again</x-aura::button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-aura::button type="submit" variant="ghost">Sign out</x-aura::button>
        </form>
    </div>
</x-layouts.auth>
