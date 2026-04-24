<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Page;
use App\Models\Project;
use App\Support\Localization\Locale;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/admin';

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('contact-form', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });


        Route::bind('localizedBlogPost', function (string $value, $route) {
            $locale = $route?->parameter('locale');

            if (! is_string($locale) || ! Locale::isSupported($locale)) {
                $locale = Locale::fallback();
            }

            return BlogPost::query()
                ->where(function ($query) use ($value, $locale) {
                    $query->where('slug', $value)
                        ->orWhere("slug_translations->{$locale}", $value);
                })
                ->firstOrFail();
        });

        Route::bind('localizedProject', function (string $value, $route) {
            $locale = $route?->parameter('locale');

            if (! is_string($locale) || ! Locale::isSupported($locale)) {
                $locale = Locale::fallback();
            }

            return Project::query()
                ->where(function ($query) use ($value, $locale) {
                    $query->where('slug', $value)
                        ->orWhere("slug_translations->{$locale}", $value);
                })
                ->firstOrFail();
        });

        Route::bind('localizedPage', function (string $value, $route) {
            $locale = $route?->parameter('locale');

            if (! is_string($locale) || ! Locale::isSupported($locale)) {
                $locale = Locale::fallback();
            }

            return Page::query()
                ->where(function ($query) use ($value, $locale) {
                    $query->where('slug', $value)
                        ->orWhere("slug_translations->{$locale}", $value);
                })
                ->firstOrFail();
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
