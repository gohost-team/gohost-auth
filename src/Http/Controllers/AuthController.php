<?php

namespace GohostAuth\Http\Controllers;

use GohostAuth\Enums\UserType;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            return redirect()->route('dashboard');
        }

        return view('gohost-auth::auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $cookie = $this->authJWTToken();

            return redirect()->route('dashboard')->withCookie($cookie);
        }
 
        return back()->withErrors([
            'error' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {        
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $cookie = Cookie::forget(config('gh-auth.token_key'));
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
        }
        
        return redirect()->route('dashboard')->withCookie($cookie);
    }

    protected function authJWTToken()
    {
        $user = Auth::user();

        $token = auth('platform')->login($user);
        $expire = time() + env('JWT_TTL', 60) * 60;

        return cookie(config('gh-auth.token_key'), $token, $expire);
    }
}
