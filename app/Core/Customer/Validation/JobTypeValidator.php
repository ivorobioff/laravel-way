<?php
namespace RealEstate\Core\Customer\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\JobTypeService;
use RealEstate\Core\JobType\Validation\Rules\JobTypeExists as LocalExists;
use RealEstate\Core\JobType\Services\JobTypeService as LocalService;
use RealEstate\Core\JobType\Entities\JobType as Local;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeValidator extends AbstractThrowableValidator
{
	/**
	 * @var LocalService
	 */
	private $localService;

	/**
	 * @var JobTypeService
	 */
	private $jobTypeService;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var Local
	 */
	private $ignored;

	/**
	 * @param Customer $customer
	 * @param ContainerInterface $container
	 * @param Local $ignored
	 */
	public function __construct(
		Customer $customer,
		ContainerInterface $container,
		Local $ignored = null
	)
	{
		$this->customer = $customer;
		$this->ignored = $ignored;

		$this->jobTypeService = $container->get(JobTypeService::class);
		$this->localService = $container->get(LocalService::class);
	}

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('title', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});

		$binder->bind('local', function(Property $property){
			$property->addRule(new LocalExists($this->localService));
		});
	}
}