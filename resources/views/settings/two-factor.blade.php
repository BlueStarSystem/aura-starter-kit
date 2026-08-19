<x-layouts.app title="Two-factor authentication">
    @php
        $user = auth()->user();

        /*
         * Not hasEnabledTwoFactorAuthentication(): with the confirm option on, that
         * method stays false until the user has entered a code, so a page keyed on
         * it would offer "turn on" forever and never let anyone finish. What matters
         * here is whether a secret exists yet, and whether it has been confirmed.
         */
        $started = ! is_null($user->two_factor_secret);
        $confirmed = ! is_null($user->two_factor_confirmed_at);
    @endphp

    <x-aura::heading level="1">Settings</x-aura::heading>
    <x-settings-nav current="settings.two-factor" />

    @if (session('status') === 'two-factor-authentication-enabled')
        <x-aura::alert variant="info" class="mb-6">
            Scan the code below with your authenticator app, then enter the six digits it shows to finish.
        </x-aura::alert>
    @endif

    @if (session('status') === 'two-factor-authentication-confirmed')
        <x-aura::alert variant="success" class="mb-6">Two-factor authentication is on.</x-aura::alert>
    @endif

    @if (session('status') === 'two-factor-authentication-disabled')
        <x-aura::alert variant="success" class="mb-6">Two-factor authentication is off.</x-aura::alert>
    @endif

    <x-aura::card class="max-w-2xl">
        <div class="mb-1 flex items-center gap-3">
            <x-aura::heading level="2">Two-factor authentication</x-aura::heading>
            @if ($confirmed)
                <x-aura::badge variant="success">On</x-aura::badge>
            @elseif ($started)
                <x-aura::badge variant="warning">Waiting for confirmation</x-aura::badge>
            @else
                <x-aura::badge variant="secondary">Off</x-aura::badge>
            @endif
        </div>

        <x-aura::text class="mb-6 text-sm">
            A second step at sign-in: a six-digit code from an app on your phone, so a stolen
            password is not enough on its own.
        </x-aura::text>

        @if (! $started)
            <form method="POST" action="{{ route('two-factor.enable') }}">
                @csrf
                <x-aura::button type="submit" variant="primary">Turn on</x-aura::button>
            </form>
        @else
            @unless ($confirmed)
                {{-- The secret is shown once, while it is being set up, and never again.
                     The QR is rendered by Fortify from the user's own secret. --}}
                <div class="mb-6 flex flex-wrap items-start gap-6">
                    <div class="rounded-lg bg-white p-3">{!! $user->twoFactorQrCodeSvg() !!}</div>

                    <div class="text-sm">
                        <p class="mb-2 text-gray-600 dark:text-gray-400">Cannot scan it? Enter this key by hand:</p>
                        <code class="break-all">{{ decrypt($user->two_factor_secret) }}</code>
                    </div>
                </div>

                <form method="POST" action="{{ route('two-factor.confirm') }}" class="aura-form-fluid mb-8 space-y-4">
                    @csrf

                    <x-aura::input
                        label="Code from your app"
                        name="code"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        required
                        :error="$errors->confirmTwoFactorAuthentication->first('code')"
                    />

                    <x-aura::button type="submit" variant="primary">Finish turning it on</x-aura::button>
                </form>
            @endunless

            <div class="mb-8">
                <x-aura::heading level="3" class="mb-1">Recovery codes</x-aura::heading>
                <x-aura::text class="mb-4 text-sm">
                    Each one signs you in once, for when the phone is not to hand. Keep them
                    somewhere other than the phone.
                </x-aura::text>

                <ul class="mb-4 grid gap-1 font-mono text-sm sm:grid-cols-2">
                    @foreach ($user->recoveryCodes() as $code)
                        <li>{{ $code }}</li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('two-factor.regenerate-recovery-codes') }}">
                    @csrf
                    <x-aura::button type="submit" variant="secondary" size="sm">Generate new codes</x-aura::button>
                </form>
            </div>

            <form method="POST" action="{{ route('two-factor.disable') }}">
                @csrf
                @method('DELETE')
                <x-aura::button type="submit" variant="danger">Turn off</x-aura::button>
            </form>
        @endif
    </x-aura::card>
</x-layouts.app>
