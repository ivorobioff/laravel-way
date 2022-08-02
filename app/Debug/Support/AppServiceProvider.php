<?php
namespace RealEstate\Debug\Support;

use Illuminate\Mail\Mailer;
use Illuminate\Support\ServiceProvider;
use RealEstate\Core\Appraisal\Interfaces\ExtractorInterface;
use RealEstate\Core\Payment\Interfaces\PaymentSystemInterface;
use RealEstate\Live\Support\PusherWrapperInterface;
use Swift_Mailer;
use RealEstate\Mobile\Support\Notifier as MobileNotifier;
use RealEstate\Debug\Support\MobileNotifier as DebugMobileNotifier;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppServiceProvider extends ServiceProvider
{
	/**
	 * @param Mailer $mailer
	 */
	public function boot(Mailer $mailer)
	{
		if ($this->app->environment() === 'tests'){
			$mailer->setSwiftMailer(new Swift_Mailer(new EmailTransport($this->app)));
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->app->environment() === 'tests'){
			$this->app->bind(PusherWrapperInterface::class, function(){
				return new PusherWrapper($this->app);
			});

			$this->app->singleton(ExtractorInterface::class, function(){
				return new Extractor();
			});

			$this->app->singleton(PaymentSystemInterface::class, function(){
				return new PaymentSystem();
			});

			$this->app->bind(MobileNotifier::class, function(){
				return new DebugMobileNotifier($this->app);
			});
		}
	}
}