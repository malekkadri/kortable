<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Support\Localization\Locale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $locale = session('locale', Locale::fallback());

    if (! Locale::isSupported($locale)) {
        $locale = Locale::fallback();
    }

    return redirect()->route('front.home', ['locale' => $locale]);
});

Route::prefix('{locale}')
    ->whereIn('locale', Locale::all())
    ->as('front.')
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');
    });
