<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Models\AuthPermission;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            } 
        }
        $this->unauthenticated($request, $guards);
    }
}
