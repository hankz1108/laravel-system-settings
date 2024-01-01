<?php

namespace Hankz\LaravelSystemSettings\Providers;

use Illuminate\Support\ServiceProvider;

class SystemSettingProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/../../config/system-settings.php' => config_path('system-settings.php'),
        ], 'default');
    }
}
