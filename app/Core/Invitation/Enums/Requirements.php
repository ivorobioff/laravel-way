<?php
namespace RealEstate\Core\Invitation\Enums;

use Restate\Libraries\Enum\EnumCollection;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Requirements extends EnumCollection
{
	/**
	 * @return string
	 */
	public function getEnumClass()
	{
		return Requirement::class;
	}
}