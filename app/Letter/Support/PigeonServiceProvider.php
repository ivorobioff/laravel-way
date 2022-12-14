<?php
namespace RealEstate\Letter\Support;

use Illuminate\Mail\MailServiceProvider;
use Swift_Mailer;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PigeonServiceProvider extends MailServiceProvider
{
	/**
	 * Register the Swift Mailer instance.
	 *
	 * @return void
	 */
	public function registerSwiftMailer()
	{
		$this->registerSwiftTransport();

		$this->app['swift.mailer'] = $this->app->share(function ($app) {
			return new Swift_Mailer(
				new PigeonTransport($app['swift.transport']->driver(), $app->make('config')->get('mail'))
			);
		});
	}

}