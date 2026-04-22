<?php

namespace App\Http\Middleware;

use App\Support\Localization\Locale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale')
            ?? $request->session()->get('locale')
            ?? Locale::fallback();

        if (! Locale::isSupported($locale)) {
            $locale = Locale::fallback();
        }

        app()->setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}
