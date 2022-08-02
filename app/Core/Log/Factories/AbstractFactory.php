<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Log\Entities\Log;
use DateTime;
use RealEstate\Core\Log\Extras\Extra;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Interfaces\ActorProviderInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractFactory implements FactoryInterface
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * @param AbstractNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = new Log();

		/**
		 * @var ActorProviderInterface $actorProvider
		 */
		$actorProvider = $this->container->get(ActorProviderInterface::class);

		$user = $actorProvider->getActor();

		$log->setUser($user);
        $log->setCustomer($notification->getOrder()->getCustomer());
		$log->setAssignee($notification->getOrder()->getAssignee());
		$log->setOrder($notification->getOrder());

		/**
		 * @var EnvironmentInterface $environment
		 */
		$environment = $this->container->get(EnvironmentInterface::class);

		if ($environment->isRelaxed() && $createdAt = $environment->getLogCreatedAt()){
			$log->setCreatedAt($createdAt);
		} else {
			$log->setCreatedAt(new DateTime());
		}

		$extra = new Extra();

		$extra[Extra::USER] = $user->getDisplayName();

		$log->setExtra($extra);

		return $log;
	}


}