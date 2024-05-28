<?php

namespace GohostAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

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

    private function createUserIfNeed($payload) 
    {
        $model = config('gh-auth.user_model');

        $user = null;
        $uniqueField = "gh_id";
        if (array_key_exists("gh_id", $payload)) {
            $user = $model::where('gh_id', $payload['gh_id'])->first();
            if (!$user) {
                $uniqueField = "email";
                $user = $model::where('email', $payload['email'])->first();
            }
        }        

        if (config('gh-auth.auto_create_account')) {
            $user = $model::updateOrCreate([
                $uniqueField => $payload[$uniqueField],
            ],[
                'gh_id' => $payload['gh_id'],
                'email' => $payload['email'],
                'is_active' => $payload['is_active'],
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
