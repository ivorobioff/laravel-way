<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\Property\OwnerInterest;
use RealEstate\Core\Appraisal\Enums\Property\OwnerInterests;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OwnerInterestsType extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumCollectionClass()
    {
        return OwnerInterests::class;
    }

    /**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return OwnerInterest::class;
	}
}