<?php

namespace App\Providers;

use App\Services\MpesaService;
use Illuminate\Support\ServiceProvider;
use App\Channels\SmsChannel;
use App\Services\TenantService;
use Twilio\Rest\Client;
// config/services.php
use Illuminate\Support\Facades\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MpesaService::class, function ($app) {
            return new MpesaService();
        });

        $this->app->singleton(TenantService::class, function ($app) {
            return new TenantService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(SmsChannel::class)
        ->needs(Client::class)
        ->give(function () {
            return new Client(config('services.twilio.sid'), config('services.twilio.token'));
        });

Notification::extend('sms', function ($app) {
  return new SmsChannel($app->make(Client::class));
});
    }
}
