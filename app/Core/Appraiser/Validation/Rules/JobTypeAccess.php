<?php
namespace RealEstate\Core\Appraiser\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeAccess extends AbstractRule
{
	/**
	 * @var CustomerService
	 */
	private $customerService;

	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var Appraiser
	 */
	private $appraiser;

	/**
	 * @param CustomerService $customerService
	 * @param AppraiserService $appraiserService
	 * @param Customer $customer
	 * @param Appraiser $appraiser
	 */
	public function __construct(
		CustomerService $customerService,
		AppraiserService $appraiserService,
		Customer $customer,
		Appraiser $appraiser
	)
	{
		$this->customerService = $customerService;
		$this->appraiserService = $appraiserService;
		$this->customer = $customer;
		$this->appraiser = $appraiser;

		$this->setIdentifier('access');
		$this->setMessage('Unable to proceed with the provided job type.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (!$this->customerService->hasPayableJobType($this->customer->getId(), $value)){
			return $this->getError();
		}

		if (!$this->appraiserService->hasPendingInvitationFromCustomer($this->appraiser->getId(), $this->customer->getId())
			&& !$this->appraiserService->isRelatedWithCustomer($this->appraiser->getId(), $this->customer->getId())){
			return $this->getError();
		}

		return null;
	}
}