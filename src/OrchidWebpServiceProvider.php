<?php

namespace Baldcat\OrchidWebp;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class OrchidWebpServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/orchid-webp.php', 'orchid-webp');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/orchid-webp.php' => config_path('orchid-webp.php'),
            ], 'config');

        }
    }
}