<?php

namespace App\Providers;

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

        Route::bind('localizedProject', function (string $value, $route) {
            $locale = $route?->parameter('locale');

            if (! is_string($locale) || ! Locale::isSupported($locale)) {
                $locale = Locale::fallback();
            }

            return Project::query()
                ->where('slug', $value)
                ->orWhere("slug_translations->{$locale}", $value)
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
