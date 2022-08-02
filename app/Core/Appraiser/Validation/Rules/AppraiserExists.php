<?php
namespace RealEstate\Core\Appraiser\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserExists extends AbstractRule
{
	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

	/**
	 * @param AppraiserService $appraiserService
	 */
	public function __construct(AppraiserService $appraiserService)
	{
		$this->appraiserService = $appraiserService;

		$this->setIdentifier('exists');
		$this->setMessage('The appraiser with the provided ID does not exist.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (!$this->appraiserService->exists($value)){
			return $this->getError();
		}

		return null;
	}
}