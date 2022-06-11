<?php

namespace App\Providers;

use Stripe\StripeClient;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('stripe', function () {
            return new StripeClient(config('stripe.secret'));
        });
    }

    public function boot()
    {
        //
    }
}
