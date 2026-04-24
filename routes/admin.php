<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\Content\HomeSectionController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\Content\ProjectCategoryController;
use App\Http\Controllers\Admin\Content\ProjectController;
use App\Http\Controllers\Admin\Content\ServiceController;
use App\Http\Controllers\Admin\Content\SiteSettingController;
use App\Http\Controllers\Admin\Content\TestimonialController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::middleware('can:manage_settings')->group(function () {
            Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
            Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
        });

        Route::middleware('can:manage_messages')->group(function () {
            Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
            Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
            Route::put('/contact-messages/{contactMessage}', [ContactMessageController::class, 'update'])->name('contact-messages.update');
        });

        Route::middleware('can:manage_pages')->group(function () {
            Route::resource('pages', PageController::class)->except('show');
            Route::resource('testimonials', TestimonialController::class)->except('show');
            Route::resource('home-sections', HomeSectionController::class)->except('show');
            Route::resource('project-categories', ProjectCategoryController::class)->except('show');
        });

        Route::middleware('can:manage_projects')->group(function () {
            Route::resource('projects', ProjectController::class)->except('show');
        });

        Route::middleware('can:manage_services')->group(function () {
            Route::resource('services', ServiceController::class)->except('show');
        });

        Route::middleware('can:manage_menus')->group(function () {
            Route::resource('menus', MenuController::class)->except('show');
            Route::post('/menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
            Route::put('/menus/{menu}/items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update');
            Route::delete('/menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');
        });

        Route::middleware('can:manage_users')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        });

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
