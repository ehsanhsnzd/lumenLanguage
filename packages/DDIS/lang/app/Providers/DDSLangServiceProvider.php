<?php

namespace DDIS\lang\app\Providers;

use DDIS\lang\app\Http\Middleware\Cors;
use DDIS\lang\app\Http\Middleware\Json;
use DDIS\lang\app\Traits\Validation;
use Illuminate\Support\ServiceProvider;

class DDSLangServiceProvider extends ServiceProvider
{
    use Validation;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function boot()
    {
        //INSERT PACKAGE ROUTES
        $this->loadRoutesFrom( dirname(__DIR__, 2).'/routes/api.php'  );
        //PUBLISH PACKAGE CONFIG FILE
        $this->mergeConfigFrom(__DIR__ . '/../../config/DDISlang.php', 'DDISlang');

        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');

        $this->bootValidator();

//        $this->publishes([__DIR__.'/../../database/Seeds/Publishes' => database_path('seeds')],'Seeds');
//        $this->publishes([__DIR__.'/../../resources/Publishes' => resource_path()],'Views');
        //INSERT PACKAGE VIEW FILE
//        $this->loadViewsFrom(__DIR__ . '/../../resources/Views', 'SocialCore');
        // Insert Package Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/Migrations');
//        $this->app->make('router')->aliasMiddleware('Cors',Cors::class);
//        $this->app->make('router')->aliasMiddleware('Json',Json::class);

        $this->app->routeMiddleware([
            'Cors' => Cors::class,
            'Json' => Json::class
        ]);

    }
}


