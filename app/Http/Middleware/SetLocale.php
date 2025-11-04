<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // priority: session -> cookie -> fallback to config('app.locale')
        $locale = Session::get('locale', $request->cookie('locale', config('app.locale')));
        if (!in_array($locale, ['en', 'hi'])) {
            $locale = config('app.locale'); // safety
        }
        App::setLocale($locale);

        return $next($request);
    }
}
