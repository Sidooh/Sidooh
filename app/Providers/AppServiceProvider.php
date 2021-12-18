<?php

namespace App\Providers;

use App\Charts\RevenueChart;
use App\Helpers\Safaricom\Mpesa;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts) {
        //
        Schema::defaultStringLength(191);

        if(config('app.env') === 'production') URL::forceScheme('https');

        Carbon::macro('timelyGreeting', function() {
            return match (true) {
                now()->isAfter(Carbon::parse('today 6pm')) => 'Good Evening',
                now()->isAfter(Carbon::parse('today 12pm')) => 'Good Afternoon',
                now()->isAfter(Carbon::parse('today 12am')) => 'Good Morning',
            };
        });

        $charts->register([
            RevenueChart::class
        ]);
    }
}
