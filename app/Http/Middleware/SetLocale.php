<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 1. On essaie de lire le cookie manuel "locale"
        $locale = $request->cookie('locale');

        // 2. Si pas de cookie, on prend la langue par défaut du site
        if (! $locale) {
            $locale = config('app.locale');
        }

        // 3. On applique la langue
        App::setLocale($locale);

        return $next($request);
    }
}