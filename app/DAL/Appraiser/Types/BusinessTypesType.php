<?php
namespace RealEstate\DAL\Appraiser\Types;

use RealEstate\Core\Appraiser\Enums\BusinessType;
use RealEstate\Core\Appraiser\Enums\BusinessTypes;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BusinessTypesType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return BusinessType::class;
	}

	/**
	 * @return string
	 */
	protected function getEnumCollectionClass()
	{
		return BusinessTypes::class;
	}
}