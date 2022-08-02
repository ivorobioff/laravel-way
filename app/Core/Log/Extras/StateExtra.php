<?php
namespace RealEstate\Core\Log\Extras;

use RealEstate\Core\Location\Entities\State;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StateExtra extends Extra
{
	/**
	 * @param string $code
	 * @param string $name
	 */
	public function __construct($code, $name)
	{
		$this[Extra::CODE] = $code;
		$this[Extra::NAME] = $name;
	}

	/**
	 * @param State $state
	 * @return StateExtra
	 */
	public static function fromState(State $state)
	{
		return new self($state->getCode(), $state->getName());
	}
}