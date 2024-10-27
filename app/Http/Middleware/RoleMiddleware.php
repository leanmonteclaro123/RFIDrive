<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Check if the authenticated user has the required role
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // If the user does not have the correct role, redirect them
        return redirect('/')->with('error', 'You do not have access to this section.');
    }
}
