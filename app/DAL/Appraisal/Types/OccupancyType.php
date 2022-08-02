<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\Property\Occupancy;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OccupancyType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Occupancy::class;
	}
}