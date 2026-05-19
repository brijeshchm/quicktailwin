<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LowercaseUrl
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $uri = $request->getRequestUri();

    // convert to lowercase
    $cleanUrl = strtolower($uri); 

    // remove trailing slash
    if ($cleanUrl !== '/') {
        $cleanUrl = rtrim($cleanUrl, '/');
    }

    // redirect if URL changed
    if ($uri !== $cleanUrl) {       
        return redirect($cleanUrl, 301);
    }

    return $next($request);
  }
}
