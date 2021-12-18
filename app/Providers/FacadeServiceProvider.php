<?php

namespace App\Providers;

use App\Helpers\LocalCarbon;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('localcarbon', function() {
            return new LocalCarbon;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {

    }
}
