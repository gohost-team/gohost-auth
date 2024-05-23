<?php

use Illuminate\Support\Facades\Route;
use GohostAuth\Http\Controllers\AuthController;

if (config('gh-auth.register_auth_router')) 
{
    Route::middleware(['web'])->group(function () 
    {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
        Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('logout');
    });
}