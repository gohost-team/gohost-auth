<?php

namespace GohostAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        UserFromCookie::handle($request);

        return $next($request);
    }
}
