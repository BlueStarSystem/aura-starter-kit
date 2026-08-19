<x-layouts.auth title="Create account" heading="Create your account">
    <form method="POST" action="{{ route('register') }}" class="aura-form-fluid space-y-5">
        @csrf

        <x-aura::input
            label="Name"
            name="name"
            value="{{ old('name') }}"
            autocomplete="name"
            required
            autofocus
            :error="$errors->first('name')"
        />

        <x-aura::input
            label="Email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            autocomplete="username"
            required
            :error="$errors->first('email')"
        />

        <x-aura::password-input
            label="Password"
            name="password"
            autocomplete="new-password"
            required
            :error="$errors->first('password')"
        />

        <x-aura::password-input
            label="Confirm password"
            name="password_confirmation"
            autocomplete="new-password"
            required
        />

        <x-aura::button type="submit" variant="primary" class="w-full">Create account</x-aura::button>
    </form>

    <x-slot:footer>
        Already registered? <x-aura::link href="{{ route('login') }}">Sign in</x-aura::link>
    </x-slot:footer>
</x-layouts.auth>
