<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorizeMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::check() && $role === 'patient') {
            return $next($request); // default for every authenticated user so allow for every authenticated user
        }

        if (!Auth::user()->hasRole($role)) {
            abort(403, 'Unauthorized. You dont have the required role!');
        }

        return $next($request);
    }
}
