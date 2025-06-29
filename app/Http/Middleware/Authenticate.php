<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            // Save the intended URL before redirecting
            session()->put('url.intended', $request->fullUrl());

            // User is not authenticated, redirect to the login page
            return redirect()->route('login')->with('error', 'Please log in or register an account to access this page.');
        }

        // User is authenticated, allow the request to proceed
        return $next($request);
    }
}
