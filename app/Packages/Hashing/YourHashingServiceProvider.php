<?php

declare(strict_types=1);

namespace App\Packages\Hashing;

use Illuminate\Support\ServiceProvider;

/**
 * Class YourHashingServiceProvider.
 */
class YourHashingServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hash', function () {
            return new YourHasher();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hash'];
    }
}
