<?php

namespace ExtensionsValley\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(__DIR__ . '/Views', 'Dashboard');

        /*$this->publishes([
            __DIR__ . '/views' => base_path('resources/views/extensionsvalley/Dashboard'),
        */

        $this->publishes([
            __DIR__ . '/../public' => public_path('packages/extensionsvalley/dashboard'),
        ]);

        $this->publishes([
            __DIR__ . '/Database/migrations' => $this->app->databasePath() . '/migrations',
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/Database/seeds' => $this->app->databasePath() . '/seeds',
        ], 'seeds');

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Load all routes
        foreach (new \DirectoryIterator(__DIR__ . '/Routes/') as $fileInfo) {
            if (!$fileInfo->isDot()) {
                include __DIR__ . '/Routes/' . $fileInfo->getFilename();
            }
        }
        // Catching up the events
        foreach (new \DirectoryIterator(__DIR__ . '/Events/') as $fileInfo) {
            if (!$fileInfo->isDot()) {
                include __DIR__ . '/Events/' . $fileInfo->getFilename();
            }
        }
    }
}
