<?php

namespace GohostAuth\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'gohost-auth'); 

        $path = realpath(__DIR__.'/../../config/gh-auth.php');
        $this->publishes([$path => config_path('gh-auth.php')], 'config');
        $this->mergeConfigFrom($path, 'gh-auth');
    }
}
