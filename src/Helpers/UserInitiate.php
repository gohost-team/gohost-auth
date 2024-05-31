<?php

namespace GohostAuth\Helpers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class UserInitiate
{
    public static function handle(Request $request)
    {
        $parser = app('tymon.jwt.parser');
        $parser->setRequest($request); 
        $token = $parser->parseToken();

        JWTAuth::setToken($token);
        $userPayload = JWTAuth::getPayload();

        if($userPayload) {
            return self::createUserIfNeed($userPayload->toArray());
        }

        return null;
    }

    private static function createUserIfNeed($payload) 
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
}
