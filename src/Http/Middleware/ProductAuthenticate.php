<?php

namespace GohostAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use GohostAuth\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class ProductAuthenticate extends Middleware
{
    // protected function authenticate($request, array $guards): void
    // {
    //     if (! $guard->check()) {
    //         $this->unauthenticated($request, $guards);
    //         return;
    //     }

    //     $user = $guard->user();
    //     abort_if(
    //         $user instanceof FilamentUser ?
    //             (! $user->canAccessProduct($panel)) :
    //             (config('app.env') !== 'local'),
    //         403,
    //     );
    // }    
}
