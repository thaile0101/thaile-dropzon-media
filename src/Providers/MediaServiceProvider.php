<?php

namespace ThaiLe\Media\Providers;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $package_name = "media";
        //routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        //view
        $this->loadViewsFrom(__DIR__.'/../../views', $package_name);

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

//        $this->publishes([
//            __DIR__.'/../../config/media.php' => config_path('media.php'),
//            __DIR__.'/../../public' => public_path('js'),
//            __DIR__.'/../../database/migrations' => database_path('migrations')
//        ], 'media');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
