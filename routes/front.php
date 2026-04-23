<?php

use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ProjectController;
use App\Http\Controllers\Front\RobotsController;
use App\Http\Controllers\Front\SitemapController;
use App\Support\Localization\Locale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $locale = session('locale', Locale::fallback());

    if (! Locale::isSupported($locale)) {
        $locale = Locale::fallback();
    }

    return redirect()->route('front.home', ['locale' => $locale]);
});

Route::get('/sitemap.xml', SitemapController::class)->name('front.sitemap');
Route::get('/robots.txt', RobotsController::class)->name('front.robots');

Route::prefix('{locale}')
    ->whereIn('locale', Locale::all())
    ->as('front.')
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{localizedProject}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
        Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact-form')->name('contact.store');
    });
