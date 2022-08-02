<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\ConcessionUnit;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ConcessionUnitType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return ConcessionUnit::class;
	}
}