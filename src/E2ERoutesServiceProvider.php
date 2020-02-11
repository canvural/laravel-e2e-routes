<?php

declare(strict_types=1);

namespace Vural\E2ERoutes;

use Illuminate\Support\ServiceProvider;
use function config_path;

class E2ERoutesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot() : void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/config.php' => config_path('e2e-routes.php'),
                ],
                'config'
            );
        }

        $this->registerRoutes();
    }

    /**
     * Register the application services.
     */
    public function register() : void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'e2e-routes');
    }

    protected function registerRoutes() : self
    {
        if ($this->app->environment() !== 'production') {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        return $this;
    }
}
