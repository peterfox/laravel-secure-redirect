<?php

namespace App\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend('redirect', function (Redirector $redirector, Container $app) {
            $redirector = new \App\Redirector($redirector->getUrlGenerator());

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            if ($app->get('session.store')) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
