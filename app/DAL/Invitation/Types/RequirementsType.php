<?php
namespace RealEstate\DAL\Invitation\Types;

use RealEstate\Core\Invitation\Enums\Requirement;
use RealEstate\Core\Invitation\Enums\Requirements;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RequirementsType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumCollectionClass()
	{
		return Requirements::class;
	}

	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Requirement::class;
	}
}