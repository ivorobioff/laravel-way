<?php
namespace RealEstate\Core\Appraiser\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AvailabilityRange extends AbstractRule
{
	public function __construct()
	{
		$this->setIdentifier('invalid');
		$this->setMessage('The away date must be before the return date.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		list($from, $to) = $value->extract();

		if ($from >= $to){
			return $this->getError();
		}

		return null;
	}
}