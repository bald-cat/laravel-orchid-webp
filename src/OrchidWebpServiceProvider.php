<?php

namespace Baldcat\OrchidWebp;

use Baldcat\OrchidWebp\Storage\CacheWebpStorage;
use Baldcat\OrchidWebp\Storage\FilesystemWebpStorage;
use Baldcat\OrchidWebp\Storage\WebpStorage;
use Illuminate\Support\ServiceProvider;

class OrchidWebpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/orchid-webp.php', 'orchid-webp');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/orchid-webp.php' => config_path('orchid-webp.php'),
            ], 'config');

        }
    }

    public function register()
    {
        $this->app->bind(WebpStorage::class, function () {
            return match (config('orchid-webp.storage')) {
                'cache' => new CacheWebpStorage(),
                'filesystem' => new FilesystemWebpStorage(),
                default => throw new \InvalidArgumentException('Invalid WEBP_STORAGE value in .env'),
            };
        });

    }

}
