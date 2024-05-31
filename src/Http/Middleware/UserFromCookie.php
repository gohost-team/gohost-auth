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
        $parser = app('tymon.jwt.parser');
        $parser->setRequest($request);
        $token = $parser->parseToken();

        JWTAuth::setToken($token);
        $userPayload = JWTAuth::getPayload();
        if($userPayload) {
            $this->createUserIfNeed($userPayload->toArray());
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

        \Log::debug('UserFromCookie: check auto_create account');
        if (config('gh-auth.auto_create_account')) {
            \Log::debug('UserFromCookie: update or create user');

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
}
