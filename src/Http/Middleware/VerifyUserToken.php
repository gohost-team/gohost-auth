<?php

namespace GohostAuth\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyUserToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        try {
            JWTAuth::setToken($token);
            if (! JWTAuth::getPayload()) {
                return response()->json(['message' => 'User not found!'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->authenticationFailedResponse('The token has expired!');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException|Exception $e) {
            return $this->authenticationFailedResponse('The token is invalid!');
        }

        return $next($request);
    }

    protected function authenticationFailedResponse($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 401);
    }
}
