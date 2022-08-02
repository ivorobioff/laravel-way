<?php
namespace RealEstate\Core\Invitation\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Customer\Entities\Customer;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserNotInvited extends AbstractRule
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

	/**
	 * @param AppraiserService $appraiserService
	 * @param Customer $customer
	 */
	public function __construct(AppraiserService $appraiserService, Customer $customer)
	{
		$this->appraiserService = $appraiserService;
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
		if ($this->appraiserService->hasPendingInvitationFromCustomer($value, $this->customer->getId())){
			return $this->getError();
		}

		return null;
	}
}