<?php
namespace RealEstate\Core\Customer\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Customer\Entities\AdditionalStatus;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalStatusUnique extends AbstractRule
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

		$this->setIdentifier('unique');
		$this->setMessage('An additional status must have an unique title in the scope of the customer.');
	}


	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if ($this->customerService->hasActiveAdditionalStatusByTitle(
			$this->customer->getId(),
			$value,
			object_take($this->currentAdditionalStatus, 'id'))
		){
			return $this->getError();
		}

		return null;
	}
}