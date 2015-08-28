<?php namespace imhu\UmengMessage;

use Illuminate\Support\ServiceProvider;

class UmengMessageServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__.'/../../config/umengMessage.php');

        $this->publishes([$source => config_path('umengMessage.php')]);

        $this->mergeConfigFrom($source, 'umengMessage');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['umIOSCast'] = $this->app->share(function ($app) {
            return new IOSCast();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["umIOSCast"];
    }

}
