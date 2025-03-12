<?php

namespace Kalimeromk\FacebookPost;

use Illuminate\Support\ServiceProvider;
use Kalimeromk\FacebookPost\Services\FacebookPostService;

class FacebookPostServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/facebook.php', 'facebook');

        $this->app->singleton(FacebookPostService::class, function (): FacebookPostService
        {
            return new FacebookPostService();
        });

        $this->app->alias(FacebookPostService::class, 'facebook-post');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/facebook.php' => config_path('facebook.php'),
        ], 'config');
    }
}
