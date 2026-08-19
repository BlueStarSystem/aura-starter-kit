<x-layouts.app title="Password">
    <x-aura::heading level="1">Settings</x-aura::heading>
    <x-settings-nav current="settings.password" />

    @if (session('status') === 'password-updated')
        <x-aura::alert variant="success" class="mb-6">Your password has been changed.</x-aura::alert>
    @endif

    <x-aura::card class="max-w-2xl">
        <x-aura::heading level="2" class="mb-1">Change password</x-aura::heading>
        <x-aura::text class="mb-6 text-sm">Use a long password you do not use anywhere else.</x-aura::text>

        <form method="POST" action="{{ route('user-password.update') }}" class="aura-form-fluid space-y-5">
            @csrf
            @method('PUT')

            <x-aura::password-input
                label="Current password"
                name="current_password"
                autocomplete="current-password"
                required
                :error="$errors->first('current_password')"
            />

            <x-aura::password-input
                label="New password"
                name="password"
                autocomplete="new-password"
                required
                :error="$errors->first('password')"
            />

            <x-aura::password-input
                label="Confirm new password"
                name="password_confirmation"
                autocomplete="new-password"
                required
            />

            <x-aura::button type="submit" variant="primary">Change password</x-aura::button>
        </form>
    </x-aura::card>
</x-layouts.app>
