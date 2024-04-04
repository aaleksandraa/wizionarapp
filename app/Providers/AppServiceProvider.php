<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         // Registracija servisa za generiranje dnevnog izvještaja
    $this->app->singleton('command.report.generate', function ($app) {
        return $app['App\Console\Commands\GenerateDailyReport'];
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
