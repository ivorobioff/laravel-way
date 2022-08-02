<?php
namespace RealEstate\Core\Location\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Location\Services\StateService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountyExistsInState extends AbstractRule
{
	/**
	 * @var StateService
	 */
	private $stateService;

	/**
	 * @var State
	 */
	private $currentState;

	public function __construct(StateService $stateService, State $currentState = null)
	{
		$this->stateService = $stateService;
		$this->currentState = $currentState;

		$this->setIdentifier('exists');
		$this->setMessage('The provided county does not belong to the provided state.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if ($value instanceof  Value){
			list($county, $state) = $value->extract();
		} else {
			$county = $value;
			$state = $this->currentState->getCode();
		}

		if (!$this->stateService->hasCounty($state, $county)){
			return $this->getError();
		}

		return null;
	}
}