<?php

namespace App\Providers;

use App\Models\Payable;
use App\Models\Payment;
use App\Observers\PayableObserver;
use App\Observers\PaymentObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Payable::observe(PayableObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
