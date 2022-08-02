<?php
namespace RealEstate\Core\Invitation\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Asc\Services\AscService;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserNotInvitedByAscAppraiser extends AbstractRule
{
	/**
	 * @var CustomerService
	 */
	private $customerService;

	/**
	 * @var AscService
	 */
	private $ascService;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @param CustomerService $customerService
	 * @param AscService $ascService
	 * @param Customer $customer
	 */
	public function __construct(CustomerService $customerService, AscService $ascService, Customer $customer)
	{
		$this->customerService = $customerService;
		$this->ascService = $ascService;
		$this->customer = $customer;

		$this->setIdentifier('already-invited');
		$this->setMessage('The invitation has been sent already to the provided appraiser.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if ($this->customerService->hasPendingInvitationForAscAppraiser($this->customer->getId(), $value)){
			return $this->getError();
		}

		$appraiser = $this->ascService->get($value)->getAppraiser();

		if ($appraiser === null){
			return null;
		}

		if ($this->customerService->hasPendingInvitationForAppraiser($this->customer->getId(), $appraiser->getId())){
			return $this->getError();
		}

		return null;
	}
}