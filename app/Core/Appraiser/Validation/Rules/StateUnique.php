<?php
namespace RealEstate\Core\Appraiser\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StateUnique extends AbstractRule
{
	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

	/**
	 * @var Appraiser
	 */
	private $currentAppraiser;

	/**
	 * @param AppraiserService $appraiserService
	 * @param Appraiser $appraiser
	 */
	public function __construct(AppraiserService $appraiserService, Appraiser $appraiser)
	{
		$this->appraiserService = $appraiserService;
		$this->currentAppraiser = $appraiser;

		$this->setIdentifier('unique');
		$this->setMessage('The license has been added already for the specified state.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if ($this->appraiserService->hasLicenseInState($this->currentAppraiser->getId(), $value)){
			return $this->getError();
		}

		return null;
	}
}