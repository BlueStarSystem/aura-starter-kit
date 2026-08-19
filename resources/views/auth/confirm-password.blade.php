<x-layouts.auth title="Confirm password" heading="Confirm your password">
    <x-slot:subheading>This area needs your password again before you continue.</x-slot:subheading>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <x-aura::password-input
            label="Password"
            name="password"
            autocomplete="current-password"
            required
            autofocus
            :error="$errors->first('password')"
        />

        <x-aura::button type="submit" variant="primary" class="w-full">Confirm</x-aura::button>
    </form>
</x-layouts.auth>
