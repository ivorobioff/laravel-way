<?php
namespace RealEstate\DAL\User\Types;

use RealEstate\Core\User\Enums\Platform;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PlatformType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Platform::class;
	}
}