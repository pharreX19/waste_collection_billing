<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Schedule $schedule): void
    {
        // $schedule->command('payables:generate')->monthlyOn(1, '00:00');
    }
}
