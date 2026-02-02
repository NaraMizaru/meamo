<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Check if user has one of the allowed roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect based on their actual role if they try to access unauthorized area
        if ($user->role === 'admin' || $user->role === 'admin_web') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
