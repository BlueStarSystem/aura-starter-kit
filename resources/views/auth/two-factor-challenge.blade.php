<x-layouts.auth title="Two-factor authentication" heading="Two-factor authentication">
    {{-- Two forms, one visible at a time: the six-digit code from the authenticator,
         or a recovery code for whoever lost the phone. Alpine keeps the toggle
         client-side so neither form needs a round trip. --}}
    <div x-data="{ recovery: false }" class="space-y-5">
        <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5" x-show="! recovery">
            @csrf

            <x-aura::text class="text-sm">Enter the six-digit code from your authenticator app.</x-aura::text>

            <x-aura::otp label="Authentication code" name="code" :length="6" />

            @error('code')
                <x-aura::alert variant="danger">{{ $message }}</x-aura::alert>
            @enderror

            <x-aura::button type="submit" variant="primary" class="w-full">Sign in</x-aura::button>
        </form>

        <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5" x-show="recovery" x-cloak>
            @csrf

            <x-aura::text class="text-sm">Enter one of your recovery codes.</x-aura::text>

            <x-aura::input
                label="Recovery code"
                name="recovery_code"
                autocomplete="one-time-code"
                :error="$errors->first('recovery_code')"
            />

            <x-aura::button type="submit" variant="primary" class="w-full">Sign in</x-aura::button>
        </form>

        <button type="button" class="w-full text-center text-sm text-gray-600 underline dark:text-gray-400" x-on:click="recovery = ! recovery">
            <span x-show="! recovery">Use a recovery code instead</span>
            <span x-show="recovery" x-cloak>Use an authentication code instead</span>
        </button>
    </div>
</x-layouts.auth>
