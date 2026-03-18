<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowGuest
{
    /**
     * Allow guests to access public resources
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow both authenticated and non-authenticated users
        return $next($request);
    }
}
