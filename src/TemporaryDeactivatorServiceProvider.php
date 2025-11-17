<?php

namespace NemanjaIlic\ModelDeactivator;

use Illuminate\Support\ServiceProvider;

class TemporaryDeactivatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'deactivator');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/deactivator')
        ], 'views');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ], 'migrations');

        $router = $this->app['router'];
        $router->aliasMiddleware('block.deactivated', \NemanjaIlic\ModelDeactivator\Middleware\BlockDeactivated::class);

        $this->app->singleton('deactivator', function ($app) {
            return new Services\DeactivationService;
        });
    }

    public function register()
    {
    }
}