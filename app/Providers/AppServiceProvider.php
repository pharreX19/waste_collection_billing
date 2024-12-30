<?php

namespace App\Providers;

use App\Models\Payable;
use App\Models\Payment;
use App\Observers\PayableObserver;
use App\Observers\PaymentObserver;
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
        Payable::observe(PayableObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
