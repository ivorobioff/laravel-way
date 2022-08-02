<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\Property\BestPersonToContact;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BestPersonToContactType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return BestPersonToContact::class;
	}
}