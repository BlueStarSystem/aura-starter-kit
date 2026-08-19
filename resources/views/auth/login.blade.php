<x-layouts.auth title="Sign in" heading="Sign in">
    <x-slot:subheading>Welcome back.</x-slot:subheading>

    <form method="POST" action="{{ route('login') }}" class="aura-form-fluid space-y-5">
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

        <x-aura::password-input
            label="Password"
            name="password"
            autocomplete="current-password"
            required
            :error="$errors->first('password')"
        />

        <div class="flex items-center justify-between">
            <x-aura::checkbox label="Remember me" name="remember" />

            @if (Route::has('password.request'))
                <x-aura::link href="{{ route('password.request') }}" class="text-sm">Forgot password?</x-aura::link>
            @endif
        </div>

        <x-aura::button type="submit" variant="primary" class="w-full">Sign in</x-aura::button>
    </form>

    @if (Route::has('register'))
        <x-slot:footer>
            No account? <x-aura::link href="{{ route('register') }}">Create one</x-aura::link>
        </x-slot:footer>
    @endif
</x-layouts.auth>
