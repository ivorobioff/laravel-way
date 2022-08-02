<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\Property\ValueType;
use RealEstate\Core\Appraisal\Enums\Property\ValueTypes;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ValueTypesType extends EnumType
{
	protected function getEnumCollectionClass()
	{
		return ValueTypes::class;
	}

	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return ValueType::class;
	}
}