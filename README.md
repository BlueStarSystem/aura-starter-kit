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

- A layout, a landing page and a dashboard built from real Aura components — not screenshots
  of them.
- `resources/css/app.css` with the Aura import, the `@source` lines Tailwind needs to see the
  package's own views, and a `@theme` block holding the primary colour scale. Change the scale
  and every component follows; there is nothing else to touch.
- Dark mode decided before the first paint, so the stored choice never shows a white flash.
- `php artisan aura:install` already run for you by `post-create-project-cmd`.

## What is not here yet

Stated plainly, because a starter kit that pretends to be finished wastes your afternoon:

- **No authentication.** The official Laravel starter kits ship login, registration, password
  reset and two-factor via Fortify. This one ships none of it. That is the single largest piece
  of remaining work.
- **No settings or profile pages.**
- **The test suite fails until you build the assets.** `@vite` throws without a manifest, which
  is true of every Laravel starter kit; run `npm install && npm run build` first.

## Requirements

- PHP 8.3+
- Laravel 13
- Node 20+ for the asset build

## Where to go next

- Every component, with live previews: [aura-ui.com/components](https://aura-ui.com/components)
- `/aura/playground` in your new application, to browse them running in your own theme
- `php artisan aura:add card` to copy a component's source into your project and own it
- `php artisan aura:doctor --a11y` to check your own templates

## License

MIT.
