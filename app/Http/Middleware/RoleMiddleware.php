<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect if not logged in
        }
        // Convert comma-separated roles into an array
       

        // Log::info('Middleware Triggered: User Role - ' . Auth::user()->role);
        // Log::info('Allowed Roles: ' . json_encode($roles));
        // Check if the user's role is in the allowed roles
        if (!in_array(Auth::user()->role, $roles,true)) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }


        return $next($request);
    }
}
