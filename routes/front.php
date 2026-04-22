<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/'.config('app.fallback_locale'));

Route::prefix('{locale}')
    ->whereIn('locale', config('kortable.locales'))
    ->middleware(['set.locale'])
    ->as('front.')
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');
    });
