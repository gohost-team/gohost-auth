<?php

namespace GohostAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if ($token !== env('API_AUTH_TOKEN')) {
            return response()->json([
                'message' => 'Access denied!',
            ], 403);
        }

        return $next($request);
    }
}
