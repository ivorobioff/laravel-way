<?php
namespace RealEstate\DAL\Appraiser\Types;

use RealEstate\Core\Appraiser\Enums\CompanyType;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CompanyTypeType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return CompanyType::class;
	}
}