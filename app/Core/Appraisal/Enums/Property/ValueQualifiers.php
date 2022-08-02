<?php
namespace RealEstate\Core\Appraisal\Enums\Property;

use Restate\Libraries\Enum\EnumCollection;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ValueQualifiers extends EnumCollection
{
	/**
	 * @return string
	 */
	public function getEnumClass()
	{
		return ValueQualifier::class;
	}
}