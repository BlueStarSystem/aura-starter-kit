<x-layouts.auth title="Choose a new password" heading="Choose a new password">
    <form method="POST" action="{{ route('password.update') }}" class="aura-form-fluid space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-aura::input
            label="Email"
            name="email"
            type="email"
            value="{{ old('email', $request->email) }}"
            autocomplete="username"
            required
            autofocus
            :error="$errors->first('email')"
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

        <x-aura::button type="submit" variant="primary" class="w-full">Save the new password</x-aura::button>
    </form>
</x-layouts.auth>
