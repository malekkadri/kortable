<?php

use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', [LocalizationController::class, 'switch'])
    ->whereIn('locale', config('kortable.locales'))
    ->name('localization.switch');
