# Aura UI Starter Kit

A Laravel application skeleton with [Aura UI](https://aura-ui.com) already wired in: Blade
components, Livewire, Tailwind CSS 4, dark mode that does not flash, and a token scale you
change in one file to restyle the whole application.

```bash
laravel new my-app --using=bluestarsystem/aura-starter-kit
cd my-app
npm install && npm run build
composer run dev
```

No account, no licence key: it installs the MIT package from Packagist.

## What you get

- A layout, a landing page, a dashboard and a live component overview built from real Aura
  components — not screenshots of them.
- Authentication via Laravel Fortify, with every screen built from those same components.
- `resources/css/app.css` with the Aura import, the `@source` lines Tailwind needs to see the
  package's own views, and a `@theme` block holding the primary colour scale. Change the scale
  and every component follows; there is nothing else to touch.
- Dark mode decided before the first paint, so the stored choice never shows a white flash.
- `php artisan aura:install` already run for you by `post-create-project-cmd`.

## Authentication

Laravel Fortify, with the screens built from Aura components: sign in, registration, forgot
password, reset password, password confirmation and the two-factor challenge — including the
recovery-code path for whoever lost their phone.

Fortify is headless: it owns the routes and the logic, this kit owns the screens. Change what
is enabled in `config/fortify.php`, and change how a user is created in
`app/Actions/Fortify/CreateNewUser.php`.

The dashboard sits behind `auth`; the landing page and the component overview stay public,
because a kit that hides its own shop window shows nothing to the person deciding whether to
use it.

## Settings

Under `/settings`, behind `auth`: the profile, the password, and two-factor authentication with
its QR code, its recovery codes, and the confirmation step that only counts it as on once a code
has actually worked. The two-factor page asks for the password again before it will show a
secret, matching what Fortify enforces on the endpoints behind it.

Email verification is off, as it is in a plain Laravel install — but its screen is here and
wired, so turning it on really is one uncommented line in `config/fortify.php` plus
`MustVerifyEmail` on the user model.

## What is not here yet

Stated plainly, because a starter kit that pretends to be finished wastes your afternoon:

- **Passkeys are off.** Fortify ships them; they need a WebAuthn ceremony in JavaScript this kit
  does not have. A sign-in button that cannot sign anyone in is worse than no button.
- **The test suite fails until you build the assets.** `@vite` throws without a manifest, which
  is true of every Laravel starter kit; run `npm install && npm run build` first. CI does it in
  the right order.

## Requirements

- PHP 8.4+ (the Symfony 8 components Laravel 13 depends on require 8.4.1)
- Laravel 13
- Node 20+ for the asset build

## Where to go next

- Every component, with live previews: [aura-ui.com/components](https://aura-ui.com/components)
- `/aura/playground` in your new application, to browse them running in your own theme
- `php artisan aura:add card` to copy a component's source into your project and own it
- `php artisan aura:doctor --a11y` to check your own templates

## License

MIT.
