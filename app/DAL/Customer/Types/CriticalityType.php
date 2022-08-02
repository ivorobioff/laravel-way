<?php
namespace RealEstate\DAL\Customer\Types;

use RealEstate\Core\Customer\Enums\Criticality;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CriticalityType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Criticality::class;
	}
}