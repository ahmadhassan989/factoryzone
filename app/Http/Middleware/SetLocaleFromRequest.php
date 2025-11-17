<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocaleFromRequest
{
    public function handle(Request $request, Closure $next)
    {
        $available = ['en', 'ar'];
        $locale = $request->get('lang');

        if ($locale && in_array($locale, $available, true)) {
            $request->session()->put('app_locale', $locale);
        }

        $locale = $request->session()->get('app_locale', config('app.locale'));

        app()->setLocale($locale);

        return $next($request);
    }
}

