<?php
namespace RealEstate\Support;

use Illuminate\Foundation\Application;
use Monolog\Handler\LogglyHandler;
use Monolog\Logger;
use Illuminate\Config\Repository as Config;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LogglyRegistrar
{
	/**
	 * Bootstrap the given application.
	 *
	 * @param  Application  $app
	 * @return void
	 */
	public function bootstrap(Application $app)
	{
		/**
		 * @var Config $config
		 */
		$config = $app->make('config');

		if ($config->get('services.loggly.enabled', false)){
			$app->configureMonologUsing(function(Logger $logger) use ($config){
				$handler = new LogglyHandler($config->get('services.loggly.token'));
				$handler->setTag('vp_'.$config->get('app.context'));
				$logger->pushHandler($handler);
			});
		}
	}

}