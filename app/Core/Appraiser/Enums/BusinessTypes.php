<?php
namespace RealEstate\Core\Appraiser\Enums;

use Restate\Libraries\Enum\EnumCollection;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BusinessTypes extends EnumCollection
{
	/**
	 * @return string
	 */
	public function getEnumClass()
	{
		return BusinessType::class;
	}
}