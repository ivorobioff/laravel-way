<?php
namespace RealEstate\Core\Customer\Enums;

use Restate\Libraries\Enum\EnumCollection;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Formats extends EnumCollection
{
	/**
	 * @return string
	 */
	public function getEnumClass()
	{
		return Format::class;
	}
}