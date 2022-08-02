<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\Property\ApproachesToBeIncluded;
use RealEstate\Core\Appraisal\Enums\Property\ApproachToBeIncluded;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ApproachesToBeIncludedType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return ApproachToBeIncluded::class;
	}

	/**
	 * @return string
	 */
	protected function getEnumCollectionClass()
	{
		return ApproachesToBeIncluded::class;
	}
}