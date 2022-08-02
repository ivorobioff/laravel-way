<?php
namespace RealEstate\Core\Customer\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\Shared\Validation\Rules\Phone;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Validation\Inflators\PasswordInflator;
use RealEstate\Core\User\Validation\Inflators\UsernameInflator;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomerValidator extends AbstractThrowableValidator
{
	/**
	 * @var UserService
	 */
	private $userService;

	/**
	 * @var EnvironmentInterface
	 */
	private $environment;

	/**
	 * @var Customer
	 */
	private $currentCustomer;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->userService = $container->get(UserService::class);
		$this->environment = $container->get(EnvironmentInterface::class);
	}

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('name', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank());
		});

		$binder->bind('phone', function(Property $property){
			$property
				->addRule(new Phone());
		});

		$binder->bind('username', new UsernameInflator($this->userService, $this->environment, $this->currentCustomer));
		$binder->bind('password', new PasswordInflator($this->environment));
	}

	/**
	 * @param Customer $customer
	 * @return $this
	 */
	public function setCurrentCustomer(Customer $customer)
	{
		$this->currentCustomer = $customer;
		return $this;
	}
}