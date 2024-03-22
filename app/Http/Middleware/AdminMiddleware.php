<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Check if the user has the "admin" role
            if (Auth::user()->roles->contains('name', 'admin')) {
                return $next($request);
            }
        }

        // Redirect or return a forbidden response if not authorized
        return redirect()->route('dashboard')->with('error', 'Unauthorized');
    }
}
