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
