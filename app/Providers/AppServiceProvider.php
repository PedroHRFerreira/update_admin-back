<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \App\Http\Middleware\CorsMiddleware;
use Closure;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Intercepta todas as requisições e adiciona CORS
        app()->afterResolving('router', function ($router) {
            $router->pushMiddlewareToGroup('api', CorsMiddleware::class);
        });
    }
}
