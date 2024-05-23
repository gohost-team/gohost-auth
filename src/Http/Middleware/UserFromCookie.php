<?php

namespace GohostAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use GohostAuth\Models\User;

class UserFromCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user) {
            return $next($request);    
        }

        $token = $request->cookie(config('gh-auth.token_key'));
        if (!$token) {
            return $next($request);
        }

        JWTAuth::setToken($token);
        $userPayload = JWTAuth::getPayload();

        $user = $this->createUserIfNeed($userPayload);
        if ($user) {
            $this->autoLogin($user);
        }

        return $next($request);
    }

    private function createUserIfNeed($userPayload) 
    {
        $user = User::where('email', $payload['email'])->first();
        if (config('gh-auth.auto_create_account')) {
            User::updateOrCreate([
                'email' => $payload['email'],
            ],[
                'name' => $payload['name'],
                'type' => $payload['type'],
                'permissions' => $payload['permissions'],
            ]);
        }

        return $user;
    }

    private function autoLogin($user)
    {
        Auth::login($user);
    }
}
