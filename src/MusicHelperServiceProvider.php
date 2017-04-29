<?php

namespace Utvarp\MusicHelper;

use Illuminate\Support\ServiceProvider;

class MusicHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/music-helper.php' => config_path('music-helper.php'),
            ], 'config');

            /*
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'music-helper');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/utvatp/music-helper'),
            ], 'views');
            */
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'music-helper');
    }
}
