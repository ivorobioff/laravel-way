<?php
namespace RealEstate\Console\Artisan;

use Illuminate\Foundation\Providers\ArtisanServiceProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ServiceProvider extends ArtisanServiceProvider
{
	protected function registerOptimizeCommand()
	{
		$this->app->singleton('command.optimize', function ($app) {
			return new FixedOptimizeCommand($app['composer']);
		});
	}
}