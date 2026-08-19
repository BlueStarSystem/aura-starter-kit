<x-layouts.auth title="Reset password" heading="Reset your password">
    <x-slot:subheading>We will email you a link to choose a new one.</x-slot:subheading>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <x-aura::input
            label="Email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            autocomplete="username"
            required
            autofocus
            :error="$errors->first('email')"
        />

        <x-aura::button type="submit" variant="primary" class="w-full">Email the link</x-aura::button>
    </form>

    <x-slot:footer>
        <x-aura::link href="{{ route('login') }}">Back to sign in</x-aura::link>
    </x-slot:footer>
</x-layouts.auth>
