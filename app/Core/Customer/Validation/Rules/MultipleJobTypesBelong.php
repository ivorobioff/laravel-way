<?php
namespace RealEstate\Core\Customer\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MultipleJobTypesBelong extends AbstractRule
{
	/**
	 * @var CustomerService
	 */
	private $customerService;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var bool
	 */
	private $isRelaxed;

	/**
	 * @param CustomerService $customerService
	 * @param Customer $customer
	 * @param bool $isRelaxed
	 */
	public function __construct(CustomerService $customerService, Customer $customer, $isRelaxed = false)
	{
		$this->isRelaxed = $isRelaxed;
		$this->customerService = $customerService;
		$this->customer = $customer;

		$this->setIdentifier('not-belong');
		$this->setMessage('One of the provided job types does not belong to the specified customer.');
	}

	/**
	 * @param array $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (count($value) === 0){
			return null;
		}

		if (!$this->hasJobTypes($value)){
			return $this->getError();
		}

		return null;
	}

	/**
	 * @param array $value
	 * @return bool
	 */
	private function hasJobTypes(array $value)
	{
		if ($this->isRelaxed){
			return $this->customerService->hasJobTypes($this->customer->getId(), $value);
		}

		return $this->customerService->hasVisibleJobTypes($this->customer->getId(), $value);
	}
}