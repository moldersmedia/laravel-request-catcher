<?php namespace MoldersMedia\RequestCatcher\Catcher\Providers;

use App\Http\Kernel;
use Barryvdh\Cors\HandleCors;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use MoldersMedia\RequestCatcher\Catcher\Middleware\RequestCatcherMiddleware;

class RequestCatcherServiceProvider extends ServiceProvider
{
    public function register()
    {



        $this->app->register(\Barryvdh\Cors\ServiceProvider::class);

    }

    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '../../../routes/routes.php');
        $this->mergeConfigFrom(__DIR__ . '/../../config/request-catcher.php', 'request-catcher');
        $this->loadMigrationsFrom(__DIR__ . '../../../migrations/');

        $router->middlewareGroup('request-catcher', [
            HandleCors::class,
            RequestCatcherMiddleware::class
        ]);
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'request-catcher');

        $this->publishes([
            __DIR__ . '/../../migrations/'                => base_path(config('request-catcher.vendor.migrations_path')),
        ]);

        $this->publishes([
            __DIR__ . '/../../config/request-catcher.php' => config_path('request-catcher.php'),
        ]);
    }
}