<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Console\Migrations\RefreshCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrateCommand::class,
                RollbackCommand::class,
                StatusCommand::class,
                RefreshCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
