<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\Property\ValueQualifier;
use RealEstate\Core\Appraisal\Enums\Property\ValueQualifiers;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ValueQualifiersType extends EnumType
{
	protected function getEnumCollectionClass()
	{
		return ValueQualifiers::class;
	}

	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return ValueQualifier::class;
	}
}