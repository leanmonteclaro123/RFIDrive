<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::guard('admin')->user();

        if (!$user || $user->role !== $role) {
            // Redirect to a specific route or show an error
            return redirect()->route('admin.dashboard')->withErrors(['You do not have access to this section.']);
        }

        return $next($request);
    }
}

