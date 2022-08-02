<?php
namespace RealEstate\Core\Appraiser\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Shared\Objects\MonthYearPair;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CertifiedDate extends AbstractRule
{
	public function __construct()
	{
		$this->setIdentifier('format');
		$this->setMessage('The certified date must provide an integer between 1 and 12 indicating a month'.
			' and an integer greater than 1950 and less than current year inclusively indicating a year.');
	}

	/**
	 * @param MonthYearPair|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if ($value->getYear() < 1950 || $value->getYear() > (int)(new DateTime())->format('Y')){
			return $this->getError();
		}

		return null;
	}
}