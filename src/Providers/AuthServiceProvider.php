<?php

namespace GohostAuth\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire;
use GohostAuth\Livewire\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'gohost-auth');
        $this->loadViewsFrom(__DIR__.'/../resources/emails', 'gohost-email');

        $path = realpath(__DIR__.'/../../config/gh-auth.php');
        $this->publishes([$path => config_path('gh-auth.php')], 'config');
        $this->mergeConfigFrom($path, 'gh-auth');

        Livewire::component('gohost-auth::reset-password', ResetPassword::class);

        $file = __DIR__.'/../url.php';
        require_once $file;
    }
}
