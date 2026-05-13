<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SeoLogService;
class SeoLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind(SeoLogService::class, function ($app) {
        // return new SeoLogService();
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
