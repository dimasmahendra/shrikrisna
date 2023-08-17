<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        return $next($request);
    }
}
