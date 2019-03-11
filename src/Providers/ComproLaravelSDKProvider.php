<?php

namespace ComproLaravelSDK\Core\Providers;

use Illuminate\Support\ServiceProvider;
    
class ComproLaravelSDKProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('config.php'),
        ], "compro-laravel-sdk-config");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'compro_laravel_sdk_config');
    }
}
