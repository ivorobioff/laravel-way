<?php
namespace RealEstate\DAL\Appraiser\Types;

use RealEstate\Core\Appraiser\Enums\AchAccountType;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AchAccountTypeType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return AchAccountType::class;
	}
}