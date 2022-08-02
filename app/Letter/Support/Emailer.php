<?php
namespace RealEstate\Letter\Support;

use Illuminate\Foundation\Bus\DispatchesJobs;
use RealEstate\Core\Support\Letter\EmailerInterface;
use RealEstate\Core\Support\Letter\Email;
use Illuminate\Contracts\Container\Container;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Emailer implements EmailerInterface
{
	use DispatchesJobs;

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @param Email $email
	 */
	public function send(Email $email)
	{
		$handler = $this->container->make('config')->get('mail.emailer')[get_class($email)];

		/**
		 * @var HandlerInterface $handler
		 */
		$handler = $this->container->make($handler);

		$handler->handle($this->container->make('mailer'), $email);
	}
}