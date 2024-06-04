<?php

namespace GohostAuth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:gh_token', ['only' => ['logout']]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth('web')->attempt($credentials)) {
            $user = auth('web')->user();

            $token = auth('gh_token')->login($user);
            $expire = time() + env('JWT_TTL', 60) * 60;
            $domain = config('gh-auth.cookie_domain');
            $cookie = cookie(config('gh-auth.token_key'), $token, $expire, null, $domain);

            return redirect(home_url())->withCookie($cookie);
        }

        return back()->withErrors([
            'error' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function login(Request $request)
    {
        $user = Auth::guard('gh_token')->user();
        if ($user) {
            return redirect(home_url());
        }

        return view('gohost-auth::auth.login');
    }

    public function logout(Request $request)
    {
        auth('gh_token')->logout();
        auth('web')->logout();

        $cookie = Cookie::forget(config('gh-auth.token_key'));
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
        }

        return redirect(home_url())->withCookie($cookie);
    }

    public function resetPassword(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
        ]);
        $email = $request->input('email');

        $model = config('gh-auth.user_model');
        $user = $model::where('email', $email)->first();
        if ($user) {
            $user->sendResetPasswordEmail();
        }

        return redirect()->route('auth.token_sent');
    }

    public function newPassword(Request $request)
    {
        $token = $request->input('token');
        if (!$token) {
            return view('gohost-auth::auth.not-found');
        }

        $model = config('gh-auth.user_model');
        $user = $model::where('active_token', $token)->first();

        if (!$user || !$user->canActivable()) {
            return view('gohost-auth::auth.not-found');
        }

        return view('gohost-auth::auth.new-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $token = $request->input('token');
        if (!$token) {
            return view('gohost-auth::auth.not-found');
        }

        $model = config('gh-auth.user_model');
        $user = $model::where('active_token', $token)->first();

        if (!$user || !$user->canActivable()) {
            return view('gohost-auth::auth.not-found');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|same:password',
        ]);

        $user->activeAccount($request->input('password'));

        return redirect(login_url());
    }
}
