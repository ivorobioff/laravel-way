<?php
namespace RealEstate\Api\Support\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class TraversableCast extends AbstractRule
{
	public function __construct()
	{
		$this->setIdentifier('cast');
		$this->setMessage('The value must be traversable.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (is_traversable($value)){
			return null;
		}

		return $this->getError();
	}
}