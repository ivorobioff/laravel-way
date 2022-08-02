<?php
namespace RealEstate\Core\Location\Validation\Inflators;

use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Rules\StateExists;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StateInflator
{
	/**
	 * @var StateService
	 */
	private $stateService;

	/**
	 * @var bool
	 */
	private $isRequired = true;

	/**
	 * @param StateService $stateService
	 */
	public function __construct(StateService $stateService)
	{
		$this->stateService = $stateService;
	}

	public function __invoke(Property $property)
	{
		if ($this->isRequired){
			$property->addRule(new Obligate());
		}

		$property
			->addRule(new Length(2, 2))
			->addRule(new StateExists($this->stateService));
	}

	/**
	 * @param bool $flag
	 * @return $this
	 */
	public function setRequired($flag)
	{
		$this->isRequired = $flag;

		return $this;
	}
}