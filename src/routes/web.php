<?php

use Illuminate\Support\Facades\Route;
use GohostAuth\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;

if (config('gh-auth.register_auth_router')) 
{
    Route::group(['middleware' => ['web']], function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

        Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('reset-password', function() {
            return view("gohost-auth::auth.reset-password");
        })->name('auth.reset_password');

        Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.do_reset');
        
        Route::get('reset-password/sent', function(){
            return view("gohost-auth::auth.token-sent");
        })->name('auth.token_sent');

        Route::get('new-password', [AuthController::class, 'newPassword'])->name('auth.new_password');
        Route::post('new-password', [AuthController::class, 'updatePassword'])->name('auth.update_password');
    });
} else 
{
    Route::get('login', function (){
        return redirect(login_url());
    })->name('login');

    Route::get('new-password', function (){
        return redirect(config('gh-auth.base_url')."/new-password");
    })->name('auth.new_password');    

    Route::match(['GET', 'POST'], 'logout', function (){
            return redirect(logout_url());
    })->name('logout');
}