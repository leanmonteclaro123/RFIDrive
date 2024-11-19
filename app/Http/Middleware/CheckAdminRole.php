<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\Middleware\CheckAdminRole as Middleware;


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
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::guard('admin')->user();

        Log::info('CheckAdminRole middleware invoked with role: ' . $role);
        Log::info('Authenticated User Role: ' . optional($user)->role);

        if (!$user || $user->role !== $role) {
            return redirect()->route('admin.dashboard')->withErrors(['error' => 'Unauthorized access.']);
        }

        return $next($request);
    }
}
