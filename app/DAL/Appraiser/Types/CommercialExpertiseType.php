<?php
namespace RealEstate\DAL\Appraiser\Types;

use RealEstate\Core\Appraiser\Enums\CommercialExpertise;
use RealEstate\Core\Appraiser\Enums\CommercialExpertiseCollection;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CommercialExpertiseType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return CommercialExpertise::class;
	}

	protected function getEnumCollectionClass()
	{
		return CommercialExpertiseCollection::class;
	}
}