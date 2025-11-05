<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            // If no active role in session, set default to first assigned role
            if (!session()->has('active_role')) {
                session(['active_role' => auth()->user()->getRoleNames()->first()]);
            }
        }

        return $next($request);
    }
}
