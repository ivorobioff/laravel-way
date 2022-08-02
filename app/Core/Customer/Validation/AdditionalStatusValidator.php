<?php
namespace RealEstate\Core\Customer\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Customer\Entities\AdditionalStatus;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Customer\Validation\Rules\AdditionalStatusUnique;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalStatusValidator extends AbstractThrowableValidator
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var CustomerService
	 */
	private $customerService;

	/**
	 * @var AdditionalStatus
	 */
	private $currentAdditionalStatus;

	/**
	 * @param CustomerService $customerService
	 * @param Customer $customer
	 * @param AdditionalStatus $currentAdditionalStatus
	 */
	public function __construct(
		CustomerService $customerService,
		Customer $customer,
		AdditionalStatus $currentAdditionalStatus = null
	)
	{
		$this->customerService = $customerService;
		$this->customer = $customer;
		$this->currentAdditionalStatus = $currentAdditionalStatus;
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
				->addRule(new Length(1, 255))
				->addRule(new AdditionalStatusUnique($this->customerService, $this->customer, $this->currentAdditionalStatus));
		});
	}
}