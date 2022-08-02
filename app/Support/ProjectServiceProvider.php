<?php
namespace RealEstate\Support;

use Restate\Libraries\Support\Interfaces\ContainerAwareInterface;
use Illuminate\Support\ServiceProvider;

/**
 * The service provider where you can register what you need to be available across the project.
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ProjectServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**
         * Sets container for instances that need it
         */
        $this->app->resolving(function (ContainerAwareInterface $object) {
            $object->setContainer($this->app);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AfterPartyMiddleware::class, AfterPartyMiddleware::class);
    }
}