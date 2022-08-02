<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentTypeExists extends AbstractRule
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
	 * @param CustomerService $customerService
	 * @param Customer $customer
	 */
	public function __construct(CustomerService $customerService, Customer $customer)
	{
		$this->customer = $customer;
		$this->customerService = $customerService;

		$this->setIdentifier('exists');
		$this->setMessage('The provided additional document type does not belong to the provided customer.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (!$this->customerService->hasAdditionalDocumentType($this->customer->getId(), $value)){
			return $this->getError();
		}

		return null;
	}
}