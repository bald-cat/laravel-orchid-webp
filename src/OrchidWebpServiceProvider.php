<?php

namespace Baldcat\OrchidWebp;

use Baldcat\OrchidWebp\Models\WebpAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Orchid\Attachment\Models\Attachment;

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

    public function register()
    {
        $this->app->bind(Attachment::class, fn() => WebpAttachment::class);
    }

}