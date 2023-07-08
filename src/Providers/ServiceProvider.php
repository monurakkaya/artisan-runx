<?php

namespace Monurakkaya\ArtisanRunx\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Monurakkaya\ArtisanRunx\Commands\ArtisanRunXCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ArtisanRunXCommand::class,
            ]);
        }
    }
}
