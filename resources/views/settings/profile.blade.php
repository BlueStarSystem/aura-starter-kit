<x-layouts.app title="Profile">
    <x-aura::heading level="1">Settings</x-aura::heading>
    <x-settings-nav current="settings.profile" />

    @if (session('status') === 'profile-information-updated')
        <x-aura::alert variant="success" class="mb-6">Your profile has been updated.</x-aura::alert>
    @endif

    <x-aura::card class="max-w-2xl">
        <x-aura::heading level="2" class="mb-1">Profile information</x-aura::heading>
        <x-aura::text class="mb-6 text-sm">The name and email address on your account.</x-aura::text>

        <form method="POST" action="{{ route('user-profile-information.update') }}" class="aura-form-fluid space-y-5">
            @csrf
            @method('PUT')

            <x-aura::input
                label="Name"
                name="name"
                value="{{ old('name', auth()->user()->name) }}"
                autocomplete="name"
                required
                :error="$errors->first('name')"
            />

            <x-aura::input
                label="Email"
                name="email"
                type="email"
                value="{{ old('email', auth()->user()->email) }}"
                autocomplete="username"
                required
                :error="$errors->first('email')"
            />

            <x-aura::button type="submit" variant="primary">Save</x-aura::button>
        </form>
    </x-aura::card>
</x-layouts.app>
