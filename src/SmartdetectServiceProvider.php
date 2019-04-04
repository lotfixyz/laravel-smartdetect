<?php

namespace Lotfixyz\Smartdetect;

use Illuminate\Support\ServiceProvider;

class SmartdetectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->app->make('Lotfixyz\Smartdetect\SmartdetectController');
        $this->app->bind('smartdetect', function () {
            return new SmartdetectClass();
        });
        $this->mergeConfigFrom(__DIR__ . '/config/smartdetect.php', 'smartdetect');
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishes([__DIR__ . '/config/smartdetect.php' => config_path('smartdetect.php')]);
    }
}
