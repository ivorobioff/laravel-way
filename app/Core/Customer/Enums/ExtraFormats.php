<?php
namespace RealEstate\Core\Customer\Enums;

use Restate\Libraries\Enum\EnumCollection;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExtraFormats extends EnumCollection
{
	/**
	 * @return string
	 */
	public function getEnumClass()
	{
		return ExtraFormat::class;
	}
}