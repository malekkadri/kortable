<?php

use App\Http\Controllers\LocalizationController;
use App\Support\Localization\Locale;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', [LocalizationController::class, 'switch'])
    ->whereIn('locale', Locale::all())
    ->name('localization.switch');
