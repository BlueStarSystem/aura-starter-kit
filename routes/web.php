<?php

use App\Support\AuraCatalogue;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');

Route::get('/components', function (AuraCatalogue $catalogue) {
    return view('components-overview', [
        'catalogue' => $catalogue,
        'components' => $catalogue->components(),
        'blocks' => $catalogue->blocks(),
    ]);
})->name('components');

/*
 * Fortify owns the endpoints behind these screens; the screens themselves are
 * ours. The two-factor page asks for the password again before it will show a
 * secret, matching the confirmPassword option in config/fortify.php — otherwise
 * it would display a QR code that the endpoints then refuse to act on.
 */
Route::middleware(['auth'])->prefix('settings')->name('settings.')->group(function () {
    Route::view('/profile', 'settings.profile')->name('profile');
    Route::view('/password', 'settings.password')->name('password');
    Route::view('/two-factor', 'settings.two-factor')->middleware('password.confirm')->name('two-factor');
});
