<?php
namespace RealEstate\Core\Asc\Enums;

use Restate\Libraries\Enum\EnumCollection;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Certifications extends EnumCollection
{
	/**
	 * @return string
	 */
	public function getEnumClass()
	{
		return Certification::class;
	}
}