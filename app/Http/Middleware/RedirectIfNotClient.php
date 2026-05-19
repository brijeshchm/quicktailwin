<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RedirectIfNotClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('clients')->check()) {
            // Instead of redirecting to 'login', show the popup or redirect elsewhere
            return redirect('/business-owners'); // Or trigger your popup (e.g., via a query parameter)
        }
        return $next($request);
    }
}
