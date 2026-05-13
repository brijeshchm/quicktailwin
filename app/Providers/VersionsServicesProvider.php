<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\VersionsServices;
class VersionsServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind(VersionsServices::class, function ($app) {
        // return new VersionsServices();
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
