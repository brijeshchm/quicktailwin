<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FirebasePushService;
class EventServiceProvider extends ServiceProvider
{
    
	 protected $listen = [
        \App\Events\LeadPush::class => [
            \App\Listeners\SendLeadPushNotification::class,
        ],
    ];

	
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
